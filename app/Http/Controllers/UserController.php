<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function logout() {
        auth()->guard('web')->logout(); // Выход текущего пользователя

        return redirect()->route('login.index')->with('info', 'Вы вышли из аккаунта');
    }
}
