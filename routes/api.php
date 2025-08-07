<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->controller(UserController::class)->group(function (){
  Route::post('register','register');
  Route::post('login','login');
});