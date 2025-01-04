<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Item\ItemController;
use App\Http\Controllers\RenderController;

Route::post(config('site.renderer_callback'), 
    [RenderController::class, 'callback']
);

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

Route::prefix('my')->group(function () {
    Route::get('/avatar', function () {
        return view('user.edit-avatar');
    });
})->middleware('auth');

Route::prefix('auth')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
})->middleware('guest');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/report', function () {
        return view('welcome');
    })->name('report');
});
