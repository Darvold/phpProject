<?php

use App\Http\Middleware\CheckUserAccess;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers as ControllersNamespace;
Route::get('/cc', function () {
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('optimize');
    return 'Cache cleared successfully.';
});

Route::get('/', [ControllersNamespace\RegistAndLoginUserController::class, 'loginUser'])->name('login.index');
Route::post('/', [ControllersNamespace\RegistAndLoginUserController::class, 'loginUserPost'])->name('login.store');
Route::get('/registr', [ControllersNamespace\RegistAndLoginUserController::class, 'registrationUser'])->name('regist.index');
Route::post('/registr', [ControllersNamespace\RegistAndLoginUserController::class, 'registrationUserPost'])->name('regist.store');
Route::middleware([CheckUserAccess::class])->group(function () {
    Route::get('/home', [ControllersNamespace\HomeUserController::class, 'homeUser'])->name('home.index');
    Route::put('/home', [ControllersNamespace\HomeUserController::class, 'updateProfile'])->name('home.put');

    Route::post('/logout', [ControllersNamespace\UserController::class, 'logout'])->name('logoutUser.store');
});
