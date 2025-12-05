<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class registAndloginUserController extends Controller
{
    public function loginUser(Request $request) {
        return view('welcome');
    }
    public function loginUserPost(Request $request) {
        try {
            $data = request()->validate([
                'phone' => ['required', 'integer', 'regex:/^7[0-9]{10}$/'],
                'password' => 'required|max:255',
            ]);
        } catch (ValidationException $e) {
            return redirect()->back()->with('error', 'Что-то пошло не так, повторите попытку')->withInput();
        }
        $user = Users::where('phone', $data['phone'])
            ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Неверный номер или пароль!')->withInput();
        }

        if (password_verify($data['password'], $user->password)) {
            auth()->login($user);
            return redirect()->route('home.index');
        }

        return redirect()->back()->with('error', 'Неверный номер или пароль!')->withInput();
    }
    public function registrationUser(Request $request) {
        return view('registr');
    }
    public function registrationUserPost(Request $request) {
        try {
            $data = request()->validate([
                'fio' => 'required|string|max:255',
                'phone' => ['required', 'integer', 'regex:/^7[0-9]{10}$/'],
                'email' => 'required|email|max:255',
                'password' => 'required|max:255',
                'password_confirmation' => 'required|max:255',
            ]);
            //'phone' => ['required', 'regex:/^(\+7|8)[0-9]{10}$/'], Ожидаемый формат с префиксом +7 или 8
        } catch (ValidationException $e) {
            $errors = $e->validator->errors();
            if($errors->has('phone')) {
                return redirect()->back()->with('error', "Не правильный формат номера")->withInput();
            }
            if($errors->has('email')) {
                return redirect()->back()->with('error', "Не правильный формат почты")->withInput();
            }
            return redirect()->back()->with('error', "Что-то пошло не так, повторите попытку")->withInput();
        }

        if (preg_match('/[0-9!@#$%^&*()_+|~=`{}\[\]:";\'<>?,.\/]/', $data['fio'])) {
            // Если в поле FIO обнаружены цифры или знаки, добавляем сообщение об ошибке и перенаправляем обратно
            return redirect()->back()->with('error', 'ФИО не должно содержать цифры и специальные символы!')->withInput();
        }
        if (Users::where('email', $data['email'])->exists()) {
            return redirect()->back()->with('error', 'Данная почта уже зарегистрирована')->withInput();
        }
        if (Users::where('phone', $data['phone'])->exists()) {
            return redirect()->back()->with('error', 'Данный телефон уже зарегистрирован')->withInput();
        }
        if (strlen($data['password']) < 6) {
            return redirect()->back()->with('error', 'Пароль должен быть минимум из 6 символов!')->withInput();
        }

        if ($data['password'] !== $data['password_confirmation']) {
            return redirect()->back()->with('error', 'Пароли не совпадают!')->withInput();
        }
        // Хэшируем пароль
        $data['password'] = bcrypt($data['password']);

        $newUser = Users::create([
            'fio' => $data['fio'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => $data['password'],
            'data_reg' => Carbon::now(),
        ]);

        if ($newUser) {
            return redirect()->route('login.index')->with('success', 'Вы успешно зарегистрировались!');
        } else {
            return redirect()->back()->with('error', 'Что-то пошло не так, повторите попытку')->withInput();
        }
    }
}
