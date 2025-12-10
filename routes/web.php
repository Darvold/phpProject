<?php

use App\Http\Middleware\CheckUserAccess;
use App\Models\Session;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers as ControllersNamespace;
Route::get('/cc', function () {
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    /*Artisan::call('optimize');*/
    return 'Cache cleared successfully.';
});

Route::get('/', [ControllersNamespace\RegistAndLoginUserController::class, 'loginUser'])->name('login.index');
Route::post('/', [ControllersNamespace\RegistAndLoginUserController::class, 'loginUserPost'])->name('login.store');
Route::get('/registr', [ControllersNamespace\RegistAndLoginUserController::class, 'registrationUser'])->name('regist.index');
Route::post('/registr', [ControllersNamespace\RegistAndLoginUserController::class, 'registrationUserPost'])->name('regist.store');

Route::middleware([CheckUserAccess::class])->group(function () {
    Route::get('/home', [ControllersNamespace\HomeUserController::class, 'homeUser'])->name('home.index');
    Route::put('/home', [ControllersNamespace\HomeUserController::class, 'updateProfile'])->name('home.put');


    Route::get('/CRUD/users', [ControllersNamespace\HomeUserController::class, 'crudUsers'])->name('crudUsers.index');

    Route::get('/CRUD/books', [ControllersNamespace\HomeUserController::class, 'crudBooks'])->name('crudBooks.index');

// 2. Маршрут для AJAX/JSON запросов
    Route::get('/api/CRUD/users', function (Request $request) {
        $page = $request->get('page', 1);
        //Количество пользователей поиск
        $perPage = $request->get('per_page', 6);

        $users = Users::paginate($perPage, ['*'], 'page', $page);
        $activeUserIds = Session::getActiveUserIds();

        $users->getCollection()->transform(function ($user) use ($activeUserIds) {
            $user->is_active = in_array($user->id, $activeUserIds);
            return $user;
        });

        return response()->json([
            'users' => $users->items(),
            'current_page' => $users->currentPage(),
            'total_pages' => $users->lastPage(),
            'total_items' => $users->total(),
            'per_page' => $users->perPage()
        ]);
    })->name('users.api.get');
    Route::post('/api/CRUD/users/update', [ControllersNamespace\HomeUserController::class, 'updateUserData'])->name('userUpdate.api.get');

    //Выход из профиля
    Route::post('/logout', [ControllersNamespace\UserController::class, 'logout'])->name('logoutUser.store');
});
