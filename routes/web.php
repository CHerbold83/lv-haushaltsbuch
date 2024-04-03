<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\EditController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class,'indexAction'])->name('index');
Route::get('/detail/{date}', [DetailController::class,'detailAction'])->name('detail');
Route::get('/delete/{id}/{date}', [DetailController::class,'deleteFinance'])->name('delete_finance');
Route::get('/delete_user', [ProfileController::class,'deleteUser'])->name('delete_user');

Route::match(['GET', 'POST'], '/edit/{id?}', [EditController::class,'indexAction'])->name('edit');
Route::match(['GET', 'POST'], '/profile/{edit?}', [ProfileController::class,'profileAction'])->name('profile');
Route::match(['GET', 'POST'], '/login')->name('login');

Route::get('/login', [LoginController::class,'login'])->name('login');
Route::get('/logout', [LoginController::class,'logout'])->name('logout');

Auth::routes();
