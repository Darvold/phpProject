<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class HomeUserController extends Controller
{
    public function homeUser(Request $request) {
        return view('homeUser');
    }
    public function updateProfile(Request $request) {
        try {
            $data = $request->validate([
                'fio' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255',
                'phone' => 'nullable|string|max:11|unique:users,phone,' . auth()->id(),
            ]);
        } catch (ValidationException $e) {
            return redirect()->back()->with('error', "Произошла ошибка");
        }

        if (preg_match('/[0-9!@#$%^&*()_+|~=`{}\[\]:";\'<>?,.\/]/', $data['fio'])) {
            // Если в поле FIO обнаружены цифры или знаки, добавляем сообщение об ошибке и перенаправляем обратно
            return redirect()->back()->with('error', 'ФИО не должно содержать цифры и специальные символы!')->withInput();
        }

        Users::where('id', Auth::id())->update([
            'fio' => $data['fio'],
            'email' => $data['email'],
            'phone' => $data['phone']
        ]);
        return redirect()->back()->with('success', "Успех!");

    }
}
