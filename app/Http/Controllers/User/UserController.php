<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User\User;

class UserController extends Controller
{
    public function profile(string $name)
    {
        return view('user.profile', [
            'user' => User::with(['roles' => function ($query) {
                $query->limit(3); // Add condition to filter the relationship
            }, 'friends' => function ($query) {
                $query->limit(4);
            }])->where('name', $name)->firstOrFail()
        ]);
    }
}
