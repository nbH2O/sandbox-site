<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'site_messages';

    public $timestamps = false;

        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'message',
        'icon',
        'color'
    ];
}
