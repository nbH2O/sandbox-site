<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/members', 
    [UserController::class, 'index']
);
Route::get('/@{name}', 
    [UserController::class, 'profile']
);
