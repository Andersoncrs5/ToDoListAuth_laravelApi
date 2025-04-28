<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    echo "ON";
});


// Route::prefix('api/user')->controller(UserController::class)->group(function() { 
//     Route::middleware(IsLogged::class)->group(function () {
//         Route::get('/', "get")->name('user.get');
//         Route::delete('/', "delete")->name('user.delete');
//         Route::put('/', "update")->name('user.update');
//         Route::get('/logout', "logout")->name('auth.logout');
//     });
// });