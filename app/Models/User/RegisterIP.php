<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class RegisterIP extends Model
{
    protected $table = 'register_ips';

    protected $fillable = [
        'user_id',
        'ip_address',
        'created_at',
        'updated_at'
    ];
}
