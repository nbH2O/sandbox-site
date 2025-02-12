<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Item\ItemController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RenderController;

use App\Http\Middleware\MinPower;

Route::post(config('site.renderer_callback'), 
    [RenderController::class, 'callback']
);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/banned', 
    [UserController::class, 'banned']
)->name('banned');

Route::get('/worlds', 
    [UserController::class, 'index']
)->name('worlds');

Route::get('/market', function () {
    return view('item.index');
})->name('market');
Route::get('/${id}', 
    [ItemController::class, 'profile']
);
Route::middleware('auth')->post('/${id}/purchase', 
    [ItemController::class, 'purchase']
);


Route::get('/members', function () {
    return view('user.index');
})->name('members');

Route::get('/@{id}', 
    [UserController::class, 'profile']
);

Route::middleware('auth')->prefix('my')->group(function () {
    Route::get('/avatar', function () {
        return view('user.edit-avatar');
    })->name('avatar');
    Route::get('/notifications', function () {
        return view('user.edit-avatar');
    })->name('notifications');
    Route::get('/chats', function () {
        return view('user.edit-avatar');
    })->name('chats');
});

Route::middleware('guest')->prefix('auth')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/report', function () {
        return view('welcome');
    })->name('report');
});

Route::middleware(['auth', MinPower::class.":200"])->prefix('admin/panel')->group(function () {
    Route::match(['get', 'post'], '/item/create', 
        [AdminController::class, 'createItem']
    );
});