<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Item extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'available_from' => 'datetime',
            'available_to' => 'datetime',
        ];
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(ItemType::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Determine if the model is free
     *
     * @return bool
     */
    public function isFree(): bool
    {
        return !$this->price || $this->price === 0;
    }
    /**
     * Determine if the model is sold out
     *
     * @return bool
     */
    public function isSoldOut(): bool
    {
        return $this->attributes['is_sold_out'];
    }
    /**
     * Returns if the Item is available to purchase
     * 
     * @return bool 
     */
    public function isPurchasable(): bool
    {
        if (!$this->is_accepted)
            return false;
        if (!$this->is_onsale)
            return false;
        if ($this->is_sold_out)
            return false;
        if ($this->available_to && $this->available_to->isPast())
            return false;
        if ($this->available_from && $this->available_from->isFuture())
            return false;

        return true;
    }

}
