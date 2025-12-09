<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
            $query->whereRaw('LOWER(fio) LIKE ?', ['%' . strtolower($search) . '%']);
            // ВЫВОДИМ SQL ЗАПРОС ДО ПАГИНАЦИИ Проверка на SQL запрос
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
    public function crudBooks(Request $request) {
        return view('homeUser');
    }
}
