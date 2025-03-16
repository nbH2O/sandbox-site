<?php

namespace App\Models\Item;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

use App\Models\User\User;
use App\Models\Item\Item;

class Inventory extends Model
{
        /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'serial',
        'item_id',
        'user_id',
        'is_for_trade',
        'resale_price'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
