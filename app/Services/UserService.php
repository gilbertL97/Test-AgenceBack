<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserService
{


    public function getConsultors(): Collection
    {
        return User::query()
            ->join('permissao_sistema as p', 'cao_usuario.co_usuario', '=', 'p.co_usuario')
            ->select(['cao_usuario.co_usuario', 'cao_usuario.no_usuario'])
            ->where('p.CO_SISTEMA', 1)
            ->where('p.IN_ATIVO', 'S')
            ->whereIn('p.CO_TIPO_USUARIO', [0, 1, 2])
            ->get();
    }

    public function getRelatoria($idUser, $startDate, $endDate)
    {

        // Asegura que sean mmayores que el inicio del mes y el fin del mes auque los mese sean diferrentes
        $startDate = Carbon::parse($startDate)->startOfMonth()->format('Y-m-d');
        $endDate = Carbon::parse($endDate)->addMonthNoOverflow()->startOfMonth()->format('Y-m-d');

        $montly = DB::table('cao_fatura as f')
            ->join('cao_os as o', 'f.co_os', '=', 'o.co_os')
            ->join('cao_salario as s', 'o.co_usuario', '=', 's.co_usuario')
            ->join('cao_usuario as u', 'o.co_usuario', '=', 'u.co_usuario')
            ->select(
                DB::raw('YEAR(f.data_emissao) as ano'),
                DB::raw('MONTH(f.data_emissao) as mes'),
                DB::raw('SUM(f.valor) as valor_total'),
                DB::raw('SUM(f.total_imp_inc) as total_imp_porciento'), //numero expresado en porciento
                DB::raw('SUM(f.valor) * (SUM(f.total_imp_inc) / 100)as valor_descontado'), //valor despues de multiplcar el porciento anterior al valor
                DB::raw('f.comissao_cn as comision'),
                DB::raw('SUM(f.valor) - (SUM(f.valor) * (SUM(f.total_imp_inc) / 100)) as receita_liquida'), //receita liquida valor total -descontado  RECEITA LIQUIDA = VALOR - TOTAL_IMP_INC
                DB::raw('s.brut_salario as salario'), //aqui hiice ya lo del salario estatico para manterener la respues unida
                DB::raw('(SUM(f.valor)-(SUM(f.valor) * (SUM(f.total_imp_inc) / 100)))*(f.comissao_cn /100)   as valor_comissao'), //Valor de comisión = (VALOR – (VALOR*TOTAL_IMP_INC)) * COMISSAO_CN
                DB::raw('(SUM(f.valor) - (SUM(f.valor) * (SUM(f.total_imp_inc) / 100)))-(s.brut_salario-((SUM(f.valor)-(SUM(f.valor) * (SUM(f.total_imp_inc) / 100)))*(f.comissao_cn /100))) as lucro') //Lucro = (VALOR-TOTAL_IMP_INC) – (Costo fijo + comisión).
            )
            ->where('o.co_usuario', $idUser)
            ->whereBetween('f.data_emissao', [$startDate, $endDate])
            ->groupBy(
                DB::raw('YEAR(f.data_emissao)'),
                DB::raw('salario'),
                DB::raw('comision'),
                DB::raw('MONTH(f.data_emissao)')
            )
            ->orderBy('ano')
            ->orderBy('mes')
            ->get();
        $total = [$montly->sum('receita_liquida'), $montly->sum('salario'), $montly->sum('valor_comissao'), $montly->sum('lucro')];
        $name = User::where('co_usuario', $idUser)->value('no_usuario');
        return [
            'name' => $name,
            'mensual' => $montly,
            'total' => $total
        ];
    }
}
