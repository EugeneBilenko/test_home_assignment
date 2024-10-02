<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::prefix('users')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('users.index');
        Route::get('/create', [UsersController::class, 'create'])->name('users.add');
        Route::post('/create', [UsersController::class, 'create'])->name('users.create');
        Route::delete('/delete/{id}', [UsersController::class, 'destroy'])->name('users.destroy');
    });

    Route::prefix('records')->group(function () {
        Route::get('/', [RecordController::class, 'index'])->name('records.index');
        Route::get('/list/{id}', [RecordController::class, 'list'])->name('records.list');
        Route::get('/create', [RecordController::class, 'create'])->name('records.add');
        Route::post('/create', [RecordController::class, 'create'])->name('records.create');
        Route::get('/edit/{id}', [RecordController::class, 'edit'])->name('records.edit');
        Route::post('/update/{id}', [RecordController::class, 'update'])->name('records.update');
        Route::get('/edit/{id}', [RecordController::class, 'edit'])->name('records.edit');
    });
});
