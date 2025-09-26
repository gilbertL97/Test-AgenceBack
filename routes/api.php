<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;



Route::apiResource('customers', ClientController::class);
Route::apiResource('users', UserController::class);
