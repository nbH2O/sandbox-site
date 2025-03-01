<?php

namespace App\Models\Item;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

use App\Models\Item\Item;

class Bundle extends Model
{
    protected $table = 'item_bundle_contents';
    
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'bundle_id');
    }
    public function content(): HasOne
    {
        return $this->hasOne(Item::class);
    }
}
