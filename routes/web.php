<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AuthController;

Route::get('/', function () {
    return redirect('/admin');
});
Route::get('/dashboard', function () {
    return redirect('/admin');
});
Route::get('/login', function () {
    return redirect('/admin');
});
Route::get('/register', function () {
    return redirect('/admin');
});

Route::get('/login', fn() => redirect('/admin/login'))->name('login');
Route::get('/register', fn() => redirect('/admin/register'))->name('register');
Route::get('/dashboard', fn() => redirect('/admin'))->name('dashboard');


Route::get('user/login', function () {
    return redirect('admin/login');
})->name('user_login');
Route::get('user/register', function () {
    return redirect('admin/register');
})->name('user_register');

Route::get('/dashboard', function () {
    return redirect('/admin');
});

Route::post('user/login', [AuthController::class, 'handleLogin'])->name('user_login');
Route::post('user/register', [AuthController::class, 'handleRegister'])->name('user_register');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
