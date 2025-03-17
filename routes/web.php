<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Item\ItemController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RenderController;

use App\Http\Middleware\MinPower;
use App\Http\Middleware\HasRole;

Route::get('/', function () {
    if (Auth()->check()) {
        return redirect()->route('user.profile', ['id' => Auth()->user()->id]);
    } else {
        return view('welcome');
    }
});

Route::get('/mailable', function () {
    $token = App\Models\User\VerificationToken::find(1);
 
    return new App\Mail\VerifyEmail($token);
});

Route::get('/banned', 
    [UserController::class, 'banned']
)->name('banned');
Route::get('/verify/email/{id}/{token}', 
    [UserController::class, 'verify']
)->name('user.verify.email');

Route::get('/worlds', 
    [UserController::class, 'index']
)->name('worlds');

Route::get('/market', function () {
    return view('item.index');
})->name('market');
Route::get('/item/{id}/profile', 
    [ItemController::class, 'profile']
)->name('item.profile');
Route::middleware('auth')->post('/item/{id}/purchase', 
    [ItemController::class, 'purchase']
)->name('item.purchase');

Route::middleware('auth')->get('/market/create',
    [ItemController::class, 'createClothing']
)->name('item.create-clothing');
Route::middleware(['auth', 'throttle:6,720'])->post('/market/create',
    [ItemController::class, 'createClothing']
)->name('item.create-clothing');

Route::get('/members', function () {
    return view('user.index');
})->name('members');

Route::get('/member/{id}/profile', 
    [UserController::class, 'profile']
)->name('user.profile');
Route::get('/member/{id}/trade', 
    [UserController::class, 'trade']
)->name('user.trade');

Route::middleware('auth')->prefix('my')->group(function () {
    Route::get('/avatar', function () {
        return view('user.edit-avatar');
    })->name('avatar');
    Route::get('/settings', function () {
        return view('user.settings');
    })->name('settings');
    Route::get('/transactions', function () {
        return view('user.transactions');
    })->name('transactions');
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
    Route::get('/join', function () {
        return view('auth.register');
    })->name('register');
});

Route::middleware('auth')->group(function () {
    Route::get('/report', function () {
        return view('welcome');
    })->name('report');
});

Route::middleware(['auth', MinPower::class.":100"])->prefix('admin/panel')->group(function () {
    Route::get('/', function () {
        return view('admin.index');
    });
    Route::match(['get', 'post', 'delete'], '/site/maintenance', 
        [AdminController::class, 'siteMaintenance']
    )->middleware([MinPower::class.":250"]);

    Route::match(['get', 'post'], '/re-render', 
        [AdminController::class, 'doRender']
    )->middleware([HasRole::class.":Market Designer,250"]);

    Route::match(['get', 'post'], '/item/create', 
        [AdminController::class, 'createItem']
    )->middleware([HasRole::class.":Market Designer,250"]);
    
    Route::match(['get', 'post'], '/item/create-figure', 
        [AdminController::class, 'createFigure']
    )->middleware([HasRole::class.":Market Designer,250"]);

    Route::get('/item/queue', function () {
        return view('admin.item.queue');
    })->middleware([HasRole::class.":Moderator,200"]);
})->name('admin.');

Route::get('/402', function () {
    return view('errors.402');
});
Route::get('/404', function () {
    return view('errors.404');
});
Route::get('/419', function () {
    return view('errors.419');
});