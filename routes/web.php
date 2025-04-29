<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\NoAuth;
use App\Http\Middleware\OnAuth;
use Illuminate\Support\Facades\Route;

Route::prefix('api/user')->controller(UserController::class)->group(function () {

    Route::middleware(NoAuth::class)->group(function () {
        Route::post('register', 'register')->name('register');
        Route::post('login', 'login')->name('login');
    });

    Route::middleware(OnAuth::class)->group(function () {
        Route::get('logout', 'logout')->name('logout');
        Route::get('get', 'get')->name('get');
        Route::put('update', 'update')->name('update');
        Route::delete('delete', 'delete')->name('delete');
    });
});

Route::prefix('api/task')->controller(TaskController::class)->group(function () {

    Route::middleware(OnAuth::class)->group(function () {
        Route::get('getAllTasksOfUser', 'getAllTasksOfUser')->name('getAllTasksOfUser');
        Route::post('createTask', 'createTask')->name('createTask');
        Route::post('updateTask/{id}', 'updateTask')->name('updateTask');
        Route::delete('deleteTask/{id}', 'deleteTask')->name('deleteTask');
        Route::get('changeStatus/{id}', 'changeStatus')->name('changeStatus');
    });
});