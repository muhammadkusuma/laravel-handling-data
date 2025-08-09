<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', fn () => redirect('/users'));



Route::get('/users', [UserController::class, 'index'])->name('users.index');