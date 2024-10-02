<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/', function () {
        return response()->json(['message' => 'API test']);
    });

    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);

    Route::prefix('users')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('users.index');
        Route::post('/create', [UsersController::class, 'create'])->name('users.create');
        Route::delete('/delete/{id}', [UsersController::class, 'destroy'])->name('users.destroy');
    });

    Route::prefix('records')->group(function () {
        Route::get('/', [RecordController::class, 'index'])->name('records.index');
        Route::post('/create', [RecordController::class, 'create'])->name('records.create');
        Route::get('/edit/{id}', [RecordController::class, 'edit'])->name('records.edit');
        Route::post('/update/{id}', [RecordController::class, 'update'])->name('records.update');
        Route::delete('/delete/{id}', [RecordController::class, 'destroy'])->name('records.destroy');
    });
});
