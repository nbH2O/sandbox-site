<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\User\User;
use App\Models\Item\Item;

class AvatarItem extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'avatar_item';

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function item(): HasOne
    {
        return $this->hasOne(Item::class);
    }

}
