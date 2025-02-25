<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Item\Item;

class Avatar extends Model
{
    use HasFactory;

    public function users():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function face(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'face_id');
    }

    public function head(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'head_id');
    }

    public function torso(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'torso_id');
    }

    public function armLeft(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'arm_left_id');
    }

    public function armRight(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'arm_right_id');
    }

    public function legLeft(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'leg_left_id');
    }

    public function legRight(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'leg_right_id');
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'avatar_item')
                    ->withPivot(
                        'position_x_adjust',
                        'position_y_adjust',
                        'position_z_adjust',
                        'rotation_x',
                        'rotation_y',
                        'rotation_z',
                        'scale'
                    );
    }
}
