<?php

namespace App\Models\Item;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

use App\Models\User\User;
use App\Models\Comment;
use App\Models\Model as ModelModel;

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

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type_id',
        'name',
        'description',
        'creator_id',
        'price',
        'is_onsale',
        'is_special',
        'max_copies',
        'available_from',
        'available_to',
        'is_public',
        'render_ulid',
        'file_ulid',
        'model_id',
        'is_name_scrubbed',
        'is_description_scrubbed',
        'is_sold_out',
        'is_accepted'
    ];

    /**
     * is scurbed
     * 
     * @return string
     */
    public function getName(): string
    {
        if (!$this->is_name_scrubbed)
            return $this->name;

        return '[scrubbed'.$this->id.']';
    }
    public function getDescription(): ?string
    {
        if (!$this->is_description_scrubbed)
            return $this->description;

        return '[scrubbed'.$this->id.']';
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }


    public function type(): BelongsTo
    {
        return $this->belongsTo(ItemType::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
    // just in case
    public function user(): BelongsTo
    {
        return $this->creator();
    }

    public function model(): BelongsTo
    {
        return $this->belongsTo(ModelModel::class, 'model_id');
    }

    public function resellers(): HasMany
    {
        return $this->hasMany(Inventory::class)
                ->orderBy('resale_price', 'ASC')
                ->where('resale_price', '>', 0)
                ->with('user');
    }
    public function cheapestReseller(): HasOne
    {
        return $this->hasOne(Inventory::class)
                ->ofMany(['resale_price' => 'min'])
                ->where('resale_price', '>', 0)
                ->with('user');
    }
    /**
     * get the items's render url
     *
     * @return string
     */
    public function getRender(): string
    {   
        if ($this->is_accepted && $this->render_ulid)
            return config('site.file_url').'/'.$this->render_ulid.'.png';

        return config('site.file_url').'/default/rendering.png';
    }

    public function getCopies(): int
    {
        return Inventory::where('item_id', $this->id)
                        ->where('user_id', '!=', config('site.main_account_id'))
                        ->count();
    }
    public function getOwnedCopies($user_id): int
    {
        return Inventory::where('item_id', $this->id)
                        ->where('user_id', $user_id)
                        ->count();
    }
    public function getHoardedCopies(): int
    {
        return Inventory::where('item_id', $this->id)
                        ->select('user_id', 'item_id')
                        ->groupBy('id', 'user_id', 'item_id')
                        ->havingRaw('COUNT(*) > 1')
                        ->selectRaw('COUNT(*) as count')
                        ->sum('count');
    }
    public function isOwnedBy($user_id): bool
    {
        $res = Inventory::where('user_id', $user_id)
                        ->where('item_id', $this->id)
                        ->first();
        
        if ($res) {
            return true;
        } else {
            return false;
        }
    }
    public function isMaxCopies(): bool
    {
        return $this->max_copies ? true : false;
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
     * Determine if the model is scheduled
     *
     * @return bool
     */
    public function isScheduled(): bool
    {
        if (!$this->available_to && !$this->available_from)
            return false;
        if ($this->isSoldOut())
            return false;

        return !$this->available_to?->isPast() || !$this->available_from?->isPast();
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
        if ($this->is_sold_out && $this->max_copies)
            return false;
        if ($this->available_to && $this->available_to->isPast())
            return false;
        if ($this->available_from && $this->available_from->isFuture())
            return false;

        return true;
    }
    /**
     * Determine if the model is tradeable
     *
     * @return bool
     */
    public function isTradeable(): bool
    {
        if (!$this->is_special)
            return false;
        if (!$this->is_sold_out && $this->max_copies)
            return false;
        if ($this->isPurchasable())
            return false;

        return true;
    }

}
