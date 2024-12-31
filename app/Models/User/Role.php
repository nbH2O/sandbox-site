<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
