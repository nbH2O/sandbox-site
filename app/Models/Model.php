<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BM;

class Model extends BM
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'version',
        'data'
    ];
}
