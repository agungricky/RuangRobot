<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/','sistem.lp');

Route::get('/login',[AuthController::class, 'showlogin'])->name('login');