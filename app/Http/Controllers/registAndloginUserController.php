<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Jenssegers\Date\Date;

class registAndloginUserController extends Controller
{
    protected function loginUser(Request $request) {
        return view('welcome');
    }
    protected function registrationUser(Request $request) {
        try {
            $data = request()->validate([
                'fio' => 'required|string|max:255',
                'phone' => ['required', 'integer', 'regex:/^7[0-9]{10}$/'],
                'email' => 'required|email|max:255',
                'password' => 'required|max:255',
                'password_confirmation' => 'required|max:255',
                'region' => 'required|max:255',
                'id_al' => 'required|integer|in:1,2'
            ]);
            //'phone' => ['required', 'regex:/^(\+7|8)[0-9]{10}$/'], Ожидаемый формат с префиксом +7 или 8
        } catch (ValidationException $e) {
            $errors = $e->validator->errors();
            if($errors->has('phone')) {
                return redirect()->back()->with('error', "Что-то пошло не так, неправильный формат номера телефона")->withInput();
            }
            if($errors->has('email')) {
                return redirect()->back()->with('error', "Что-то пошло не так, неправильная почта")->withInput();
            }
            return redirect()->back()->with('error', "Что-то пошло не так, повторите попытку")->withInput();
        }

        if (preg_match('/[0-9!@#$%^&*()_+|~=`{}\[\]:";\'<>?,.\/]/', $data['fio'])) {
            // Если в поле FIO обнаружены цифры или знаки, добавляем сообщение об ошибке и перенаправляем обратно
            return redirect()->back()->with('error', 'ФИО не должно содержать цифры и специальные символы!')->withInput();
        }
        // Проверяем, существует ли адрес электронной почты в базе данных
        if (Users::where('phone', $data['phone'])->exists()) {
            return redirect()->back()->with('error', 'Что-то пошло не так, повторите попытку')->withInput();
        }

        if (strlen($data['password']) < 6) {
            return redirect()->back()->with('error', 'Пароль должен быть минимум из 6 символов!')->withInput();
        }

        if ($data['password'] !== $data['password_confirmation']) {
            return redirect()->back()->with('error', 'Пароли не совпадают!')->withInput();
        }
        if (!($data['id_al'] == 1 || $data['id_al'] == 2)) {
            return redirect()->back()->with('error', "Что-то пошло не так, повторите попытку 1")->withInput();
        }
        // Хэшируем пароль
        $data['password'] = bcrypt($data['password']);
        $newUser = Users::create([
            'fio' => $data['fio'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => $data['password'],
            'region' => $data['region'],
            'data_reg' => Date::now(),
            'id_al' => $data['id_al'],
        ]);
        if ($newUser) {
            return redirect()->route('login.index')->with('success', 'Вы успешно зарегестрировались!');
        } else {
            return redirect()->back()->with('error', 'Что-то пошло не так, повторите попытку')->withInput();
        }
    }
}
