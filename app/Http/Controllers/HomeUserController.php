<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeUserController extends Controller
{
    public function homeUser(Request $request) {
        return view('homeUser');
    }
}
