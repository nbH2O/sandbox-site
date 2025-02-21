<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class SoftMaintenance extends Model
{
    protected $table = 'site_maintenance';

    public $timestamps = false;

        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'message',
        'is_bypassable',
        'min_power'
    ];
}
