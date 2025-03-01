<?php

namespace App\Models\Item;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

use App\Models\User\User;
use App\Models\Item\Item;

class SaleLog extends Model
{
    protected $table = 'item_sale_logs';
    
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
    public function seller(): HasOne
    {
        return $this->hasOne(User::class, 'seller_id');
    }
    public function item(): HasOne
    {
        return $this->hasOne(Item::class);
    }
}
