<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers as ControllersNamespace;

Route::get('/', [ControllersNamespace\RegistAndLoginUserController::class, 'loginUser'])->name('login.index');
Route::post('/', [ControllersNamespace\RegistAndLoginUserController::class, 'loginUserPost'])->name('login.store');

Route::get('/registr', [ControllersNamespace\RegistAndLoginUserController::class, 'registrationUser'])->name('regist.index');
Route::post('/registr', [ControllersNamespace\RegistAndLoginUserController::class, 'registrationUserPost'])->name('regist.store');

Route::get('/home', [ControllersNamespace\HomeUserController::class, 'homeUser'])->name('home.index');

Route::post('/logout', [ControllersNamespace\UserController::class, 'logout'])->name('logoutUser.store');
