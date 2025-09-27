<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

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

    public function getReceitaLiquida($idUsuario, $startDate, $endDate)
    {
        $montly = DB::table('cao_fatura as f')
            ->join('cao_os as o', 'f.co_os', '=', 'o.co_os')
            ->join('cao_salario as s', 'o.co_usuario', '=', 's.co_usuario')
            ->join('cao_usuario as u', 'o.co_usuario', '=', 'u.co_usuario')
            ->select(
                DB::raw('YEAR(f.data_emissao) as ano'),
                DB::raw('MONTH(f.data_emissao) as mes'),
                DB::raw('SUM(f.valor) as valor_total'),
                DB::raw('SUM(f.total_imp_inc) as total_imp'),
                DB::raw('SUM(f.valor) - SUM(f.total_imp_inc) as receita_liquida'),
            )
            ->where('o.co_usuario', $idUsuario)
            ->whereBetween('f.data_emissao', [$startDate, $endDate])
            ->groupBy(DB::raw('YEAR(f.data_emissao)'), DB::raw('MONTH(f.data_emissao)'))
            ->orderBy('ano')
            ->orderBy('mes')
            ->get();
        $total = $montly->sum('receita_liquida');
        return [
            'mensual' => $montly,
            'total' => $total
        ];
    }

    public function getReceitaLiquidaByClient($idUsuario, $startDate, $endDate)
    {
        return DB::table('cao_fatura as f')
            ->join('cao_os as o', 'f.co_os', '=', 'o.co_os')
            ->join('cao_salario as s', 'o.co_usuario', '=', 's.co_usuario')

            ->select(
                DB::raw('YEAR(f.data_emissao) as ano'),
                DB::raw('MONTH(f.data_emissao) as mes'),
                DB::raw('SUM(f.valor) as total_receita'),
                DB::raw('o.co_usuario')
            )
            ->where('o.co_usuario', $idUsuario)
            ->whereBetween('f.data_emissao', [$startDate, $endDate])
            ->groupBy(DB::raw('YEAR(f.data_emissao)'), DB::raw('MONTH(f.data_emissao)'), DB::raw('o.co_usuario'))
            ->orderBy('ano')
            ->orderBy('mes')
            ->get();
    }
}
