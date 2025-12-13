<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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

    public function crudUsers(Request $request) {
        $page = $request->get('page', 1);
        //Количество пользователей
        $perPage = $request->get('per_page', 6);
        //Поиск пользователей по фио
        $search = $request->get('search', '');
        // Создаем запрос
        $query = Users::query();

        // Добавляем поиск по ФИО
        if ($search) {
            $query->where('fio', 'LIKE', '%' . $search . '%');
            // ВЫВОДИМ SQL ЗАПРОС ДО ПАГИНАЦИИ Проверка на SQL запрос Логи
/*           $sql = $query->toSql();
            $bindings = $query->getBindings();

            // Формируем полный SQL с подставленными значениями
            $fullSql = vsprintf(str_replace('?', "'%s'", $sql), $bindings);

            \Log::info('🔍 SQL запрос поиска:', [
                'search' => $search,
                'sql' => $sql,
                'bindings' => $bindings,
                'full_sql' => $fullSql,
                'url' => $request->fullUrl()
            ]);*/

        }

        // Получаем пагинированные данные ИЗ ЭТОГО ЗАПРОСА
        $users = $query->paginate($perPage, ['*'], 'page', $page);

        $activeUserIds = Session::getActiveUserIds();

        // Добавляем флаг активности
        $users->getCollection()->transform(function ($user) use ($activeUserIds) {
            $user->is_active = in_array($user->id, $activeUserIds);
            return $user;
        });

        // Если это AJAX запрос
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'users' => $users->items(),
                'current_page' => $users->currentPage(),
                'total_pages' => $users->lastPage(),
                'total_items' => $users->total(),
                'per_page' => $users->perPage(),
                'search_query' => $search
            ]);
        }

        // Для обычного запроса
        return view('crudUsers', [
            'users' => $users->items(),
            'currentPage' => $users->currentPage(),
            'totalPages' => $users->lastPage(),
            'totalItems' => $users->total(),
            'perPage' => $perPage,
            'searchQuery' => $search
        ]);
    }
// app/Http/Controllers/HomeUserController.php
    public function updateUserData(Request $request)
    {
        try {
            // Валидация данных
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|exists:users,id',
                'fio' => ['required',
                    'string',
                    'max:255',
                    function ($attribute, $value, $fail) {
                        if (preg_match('/[0-9!@#$%^&*()_+|~=`{}\[\]:";\'<>?,.\/]/', $value)) {
                            // Если в поле FIO обнаружены цифры или знаки, добавляем сообщение об ошибке и перенаправляем обратно
                            $fail('error', 'ФИО не должно содержать цифры и специальные символы!');
                        }

                        // Проверка на русские буквы
                        /*if (!preg_match('/^[а-яА-ЯёЁ\s\-]+$/u', $value)) {
                            $fail('ФИО должно содержать только русские буквы');
                        }*/
                    }
                ],
                'email' => [
                    'required',
                    'email',
                    'max:255',
                ],
                'phone' => [
                    'required',
                    'string',
                    'max:11',
                    'regex:/^[0-9]+$/', // только цифры
                    'unique:users,phone,' . $request->id // исключаем текущего пользователя
                ],
                'role' => 'required|integer|in:1,2,3', // 1-пользователь, 2-админ, 3-модератор
            ], [
                'id.required' => 'ID пользователя обязательно',
                'id.integer' => 'ID должен быть числом',
                'id.exists' => 'Пользователь не найден',

                'fio.required' => 'ФИО обязательно',
                'fio.string' => 'ФИО должно быть строкой',
                'fio.max' => 'ФИО не должно превышать 255 символов',

                'email.required' => 'Email обязателен',
                'email.email' => 'Неверный формат email',
                'email.max' => 'Email не должен превышать 255 символов',
                'email.unique' => 'Этот email уже используется',

                'phone.required' => 'Телефон обязателен',
                'phone.string' => 'Телефон должен быть строкой',
                'phone.digits' => 'Телефон должен состоять из 11 цифр',
                'phone.unique' => 'Этот номер телефона уже зарегистрирован',

                'role.required' => 'Роль обязательна',

            ]);

            // Если есть ошибки валидации
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ошибки валидации',
                    'errors' => $validator->errors()->toArray()
                ], 422);
            }

            // Находим пользователя
            $user = Users::find($request->id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Пользователь не найден'
                ], 404);
            }

            // нельзя редактировать администраторов, если ты не админ
            $currentUser = Auth::user();
            if ($currentUser->role != 2 && $user->role == 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Недостаточно прав для редактирования администратора'
                ], 403);
            }

            // Обновляем данные
            $user->update([
                'fio' => $request->fio,
                'email' => $request->email,
                'phone' => $request->phone,
                'role' => $request->role,
            ]);

            // Успешный ответ
            return response()->json([
                'success' => true,
                'message' => 'Данные пользователя успешно обновлены',
                'user' => $user,
                'redirect' => session('success', 'Изменения сохранены')
            ]);

        } catch (\Exception $e) {
            // Логируем ошибку
          /*  \Log::error('Ошибка обновления пользователя: ' . $e->getMessage(), [
                'request' => $request->all(),
                'user_id' => $request->id,
                'auth_user' => Auth::id()
            ]);*/

            return response()->json([
                'success' => false,
                'message' => 'Внутренняя ошибка сервера',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
    public function createUserData(Request $request)
    {
        try {
            // Валидация данных
            $validator = Validator::make($request->all(), [
                'fio' => ['required',
                    'string',
                    'max:255',
                    function ($attribute, $value, $fail) {
                        if (preg_match('/[0-9!@#$%^&*()_+|~=`{}\[\]:";\'<>?,.\/]/', $value)) {
                            $fail('error', 'ФИО не должно содержать цифры и специальные символы!');
                        }
                    }
                ],
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    'unique:users,email,' . $request->id
                ],
                'phone' => [
                    'required',
                    'string',
                    'max:11',
                    'regex:/^[0-9]+$/', // только цифры
                    'unique:users,phone,' . $request->id // исключаем текущего пользователя
                ],
                'password' => 'required|string|max:255',
                'role' => 'required|integer|in:1,2,3', // 1-пользователь, 2-админ, 3-модератор
            ], [
                'id.required' => 'ID пользователя обязательно',
                'id.integer' => 'ID должен быть числом',
                'id.exists' => 'Пользователь не найден',

                'fio.required' => 'ФИО обязательно',
                'fio.string' => 'ФИО должно быть строкой',
                'fio.max' => 'ФИО не должно превышать 255 символов',

                'email.required' => 'Email обязателен',
                'email.email' => 'Неверный формат email',
                'email.max' => 'Email не должен превышать 255 символов',
                'email.unique' => 'Этот email уже используется',

                'phone.required' => 'Телефон обязателен',
                'phone.string' => 'Телефон должен быть строкой',
                'phone.digits' => 'Телефон должен состоять из 11 цифр',
                'phone.unique' => 'Этот номер телефона уже зарегистрирован',

                'role.required' => 'Роль обязательна',

            ]);

            // Если есть ошибки валидации
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ошибки валидации',
                    'errors' => $validator->errors()->toArray()
                ], 422);
            }

            // Находим пользователя
            $user = Users::find($request->phone);

            if ($user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Телефон уже используется'
                ], 404);
            }

            // нельзя редактировать администраторов, если ты не админ
            $currentUser = Auth::user();
            if ($currentUser->role != 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Недостаточно прав для создания пользователя'
                ], 403);
            }

            // Обновляем данные
            Users::create([
                'fio' => $request->fio,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
                'data_reg' => Carbon::now(),
                'role' => $request->role,
            ]);

            // Успешный ответ
            return response()->json([
                'success' => true,
                'message' => 'Данные пользователя успешно созданы',
                'user' => $user,
                'redirect' => session('success', 'Пользователь создан')
            ]);

        } catch (\Exception $e) {
            // Логируем ошибку
          /*  \Log::error('Ошибка обновления пользователя: ' . $e->getMessage(), [
                'request' => $request->all(),
                'user_id' => $request->id,
                'auth_user' => Auth::id()
            ]);*/

            return response()->json([
                'success' => false,
                'message' => 'Внутренняя ошибка сервера',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
    public function deleteUserData(Request $request) {
        try {
            // Валидация данных
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer',
            ], [
                'id.required' => 'ID пользователя обязательно',
                'id.integer' => 'ID должен быть числом',
            ]);

            // Если есть ошибки валидации
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ошибка валидации',
                    'errors' => $validator->errors()->toArray()
                ], 422);
            }

            // Находим пользователя для удаления
            $userToDelete = Users::where('id', $request->id)->first();

            if (!$userToDelete) {
                return response()->json([
                    'success' => false,
                    'message' => 'Пользователь не был найден'
                ], 404);
            }

            // Проверка прав: нельзя удалять администраторов, если ты не админ
            $currentUser = Auth::user();

            // Если пользователь, которого удаляют - админ (role = 2)
            if ($userToDelete->role == 2 && $currentUser->role != 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Недостаточно прав для удаления администратора'
                ], 403);
            }

            // Нельзя удалять самого себя
            if ($userToDelete->id == $currentUser->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Нельзя удалить самого себя'
                ], 403);
            }

            // Удаляем пользователя
            $userToDelete->delete();

            // Успешный ответ
            return response()->json([
                'success' => true,
                'message' => 'Пользователь был удалён',
                'user' => [
                    'id' => $userToDelete->id,
                    'fio' => $userToDelete->fio
                ]
            ]);

        } catch (\Exception $e) {
            /*\Log::error('Delete user error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);*/

            return response()->json([
                'success' => false,
                'message' => 'Внутренняя ошибка сервера',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
    public function crudBooks(Request $request) {
        return view('homeUser');
    }
}
