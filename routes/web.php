<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Item\ItemController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/worlds', 
    [UserController::class, 'index']
)->name('worlds');

Route::get('/market', function () {
    return view('item.index');
})->name('market');
Route::get('/${id}', 
    [ItemController::class, 'profile']
);


Route::get('/members', function () {
    return view('user.index');
})->name('members');

Route::get('/@{name}', 
    [UserController::class, 'profile']
);
