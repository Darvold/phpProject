<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'registAndloginUserController@loginUser')
    ->name('login.index');
Route::get('/registr', 'registAndloginUserController@registrationUser')
    ->name('registr.index');
