<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{

    public function getConsultors(): Collection
    {
        return User::where('role', 'consultor')->get();
    }
}