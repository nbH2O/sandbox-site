<?php

namespace App\Models\Item;

use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    protected $table = 'item_types';

    public function item(): HasMany
    {
        return $this->hasMany(Item::class);
    }
}
