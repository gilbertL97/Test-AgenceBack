<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
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
        return DB::table('cao_fatura as f')
            ->join('cao_os as o', 'f.co_os', '=', 'o.co_os')
            ->join('cao_salario as s', 'o.co_usuario', '=', 's.co_usuario')
            ->select(DB::raw('SUM(f.valor - f.valor * s.brut_salario / 100) as receita_liquida'))
            ->where('o.co_usuario', $idUsuario)
            ->whereBetween('f.data_emissao', [$startDate, $endDate])
            ->value('receita_liquida');
    }
}
