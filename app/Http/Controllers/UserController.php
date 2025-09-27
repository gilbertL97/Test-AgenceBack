<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Models\User;
use App\Http\Requests\ReceitaLiquidaRequest;

class UserController extends Controller
{
    protected $userService;


    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function show(string $id)
    {

        return User::find($id);
    }
    public function getConsultor()
    {

        $consultors = $this->userService->getConsultors();
        return response()->json($consultors);
    }

    public function getReceitaLiquida(ReceitaLiquidaRequest $request)
    {
        $data = $request->validated();
        $receitaLiquida = $this->userService->getReceitaLiquida(
            $data['idUsuarios'],
            $data['startDate'],
            $data['endDate']
        );
        return response()->json(['receita_liquida' => $receitaLiquida]);
    }
}
