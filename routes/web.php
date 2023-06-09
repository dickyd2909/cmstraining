<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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

Route::get('/', [UserController::class, 'login'])->name('login');
Route::post('login', [UserController::class, 'login_action'])->name('login.action');
Route::get('register', [UserController::class, 'register'])->name('register');
Route::post('register', [UserController::class, 'register_action'])->name('register.action');
Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');
Route::get('admin', [UserController::class, 'admin'])->name('admin');
Route::post('admin', [UserController::class, 'admin_save'])->name('admin.action');
Route::put('admin/{id}', [UserController::class, 'admin_update'])->name('admin.update');
Route::get('admin/{id}', [UserController::class, 'admin_hapus'])->name('admin.hapus');
Route::get('logout', [UserController::class, 'logout'])->name('logout');