<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginLogoutEventController;
use App\Http\Controllers\Users;

Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::post('/user/store', [UserController::class, 'store'])->name('user.store');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

Route::get('/login-logout-events', [LoginLogoutEventController::class, 'index'])->name('login_logout_events.index');
Route::post('/login-logout-events/{event}/force-logout', [LoginLogoutEventController::class, 'forceLogout'])->name('login_logout_events.force_logout');



Route::get('/user-management', Users::class)->name('user-management');