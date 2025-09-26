<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
 use App\Models\User;

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

}
