<?php

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard',[UserController::class,'dashboard'])->name('dashboard');


Route::get('/login',[UserController::class,'login'])->name('users.login');
Route::post('/login', [UserController::class, 'loginPost'])->name('users.loginpost');

Route::get('/logout',[UserController::class,'logout'])->name('users.logout');


//users

Route::get('register', [UserController::class, 'register'])->name('users.register');
Route::post('register', [UserController::class, 'store'])->name('users.store');


Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
Route::post('/users/edit/{userId}',[UserController::class,'update'])->name('users.update');

Route::get('/users', [UserController::class, 'index'])->name('users.list');


Route::get('users/delete/{user}',[UserController::class,'destroy'])->name('users.delete');

Route::get('users/toggleBlock/{user}',[UserController::class,'toggleblock'])->name('users.toggleblock');


Route::get('/users/password/edit',[UserController::class,'editPassword'])->name('password.edit');
Route::Post('/password/update',[UserController::class,'updatePassword'])->name('password.update');

Route::get('/users/users/data', [UserController::class,'userData'])->name('users.data');

