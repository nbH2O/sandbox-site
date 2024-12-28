<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'user_roles';

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
