<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/loginUSer', 'LoginAndRegistrController@loginUser')
    ->name('login.index');
Route::get('/registr', 'LoginAndRegistrController@registrUser')
    ->name('registr.index');
