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
use App\Jobs\RenderImage;

use App\Models\Item\Inventory;
use App\Models\Item\SaleLog;

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
        'is_accepted',
        'is_pending'
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

    public function doRender($sync = false): bool
    {
        $itemTypes = config('site.item_types');
        $itemTypeIDs = array_flip(config('site.item_types'));
        $bundleTypeIDs = array_keys(config('site.bundle_item_types'));
        $defaultParts = [
            'face' => config('site.local_url').'storage/default/rig/face.png',
            'head' => config('site.local_url').'storage/default/rig/head.obj',
            'torso' => config('site.local_url').'storage/default/rig/torso.obj',
            'arm_left' => config('site.local_url').'storage/default/rig/armLeft.obj',
            'arm_right' => config('site.local_url').'storage/default/rig/armRight.obj',
            'leg_left' => config('site.local_url').'storage/default/rig/legLeft.obj',
            'leg_right' => config('site.local_url').'storage/default/rig/legRight.obj'
        ];

        $renderString = null;

        if ($this->type_id == $itemTypeIDs['hat']) {
            $modelData = ModelModel::find($this->model_id);
            $models = '';
            $xml = $modelData->data;

            $doc = new \DOMDocument();
            $doc->loadXML($xml);
            $root = $doc->documentElement; // Get the first (root) element
            $root->setAttribute('isRenderSubject', 'true');

            // Get all elements in the document
            $elements = $doc->getElementsByTagName('*');

            // Iterate over all elements and check for the 'src' attribute
            foreach ($elements as $element) {
                if ($element->hasAttribute('src')) {
                    $element->setAttribute('src', config('site.local_url').'storage/'.$element->getAttribute('src'));
                }
            }
            
            $doc->formatOutput = false;
            $res = $doc->saveXML($root);
            // fix self-closing tag crap
            $models .=  preg_replace('/<(\w+)([^>]*?)\s*\/>/', '<$1$2></$1>', $res);

            $renderString = '
                <Root name="SceneRoot">
                    '.$models.'
                </Root>
            ';

            if ($sync == true) {
                RenderImage::dispatchSync($this, $renderString);
            } else {
                RenderImage::dispatch($this, $renderString);
            }
        } elseif ($this->type_id == $itemTypeIDs['shirt'] || $this->type_id == $itemTypeIDs['pants'] || $this->type_id == $itemTypeIDs['suit']) {
            $renderString = '
                <Root name="SceneRoot">
                    <Humanoid 
                        isRenderSubject="true"

                        clothing1="'.config('site.local_url').'storage/'.$this->file_ulid.'.png"

                        face="'.$defaultParts['face'].'"
                        head="'.$defaultParts['head'].'"
                        torso="'.$defaultParts['torso'].'"
                        armLeft="'.$defaultParts['arm_left'].'"
                        armRight="'.$defaultParts['arm_right'].'"
                        legLeft="'.$defaultParts['leg_left'].'"
                        legRight="'.$defaultParts['leg_right'].'"

                        headColor="#D3D3D3"
                        torsoColor="#D3D3D3"
                        armLeftColor="#D3D3D3"
                        armRightColor="#D3D3D3"
                        legLeftColor="#D3D3D3"
                        legRightColor="#D3D3D3"
                    >
                    </Humanoid>
                </Root>
            ';

            if ($sync == true) {
                RenderImage::dispatchSync($this, $renderString);
            } else {
                RenderImage::dispatch($this, $renderString);
            }
        } elseif ($this->type_id == $itemTypeIDs['figure']) {
            $bundle = Bundle::where('bundle_id', $this->id)->with('content')->get();
            $parts = $defaultParts;

            foreach ($bundle as $bi) {
                $parts[$itemTypes[$bi->content->type_id]] = config('site.local_url').'storage/'.$bi->content->file_ulid.'.obj';
            }

            foreach ($bundle as $bi) {
                $key = $itemTypes[$bi->content->type_id];

                $renderString = '
                    <Root name="SceneRoot">
                        <Humanoid 
                            setRenderSubject="'.$key.'"

                            face="'.$parts['face'].'"
                            head="'.$parts['head'].'"
                            torso="'.$parts['torso'].'"
                            armLeft="'.$parts['arm_left'].'"
                            armRight="'.$parts['arm_right'].'"
                            legLeft="'.$parts['leg_left'].'"
                            legRight="'.$parts['leg_right'].'"

                            headColor="#D3D3D3"
                            torsoColor="#D3D3D3"
                            armLeftColor="#D3D3D3"
                            armRightColor="#D3D3D3"
                            legLeftColor="#D3D3D3"
                            legRightColor="#D3D3D3"
                        >
                        </Humanoid>
                    </Root>
                ';

                if ($sync == true) {
                    RenderImage::dispatchSync($bi->content, $renderString);
                } else {
                    RenderImage::dispatch($bi->content, $renderString);
                }
            }

            $renderString = '
                <Root name="SceneRoot">
                    <Humanoid 
                        isRenderSubject="true"

                        face="'.$parts['face'].'"
                        head="'.$parts['head'].'"
                        torso="'.$parts['torso'].'"
                        armLeft="'.$parts['arm_left'].'"
                        armRight="'.$parts['arm_right'].'"
                        legLeft="'.$parts['leg_left'].'"
                        legRight="'.$parts['leg_right'].'"

                        headColor="#D3D3D3"
                        torsoColor="#D3D3D3"
                        armLeftColor="#D3D3D3"
                        armRightColor="#D3D3D3"
                        legLeftColor="#D3D3D3"
                        legRightColor="#D3D3D3"
                    >
                    </Humanoid>
                </Root>
            ';

            if ($sync == true) {
                RenderImage::dispatchSync($this, $renderString);
            } else {
                RenderImage::dispatch($this, $renderString);
            }
        } elseif ($this->type_id == $itemTypeIDs['pack']) {
            // not added yet lo
            $renderString = '
                <Root name="SceneRoot">
                    <Humanoid 
                        isRenderSubject="true"

                        face="'.$defaultParts['face'].'"
                        head="'.$defaultParts['head'].'"
                        torso="'.$defaultParts['torso'].'"
                        armLeft="'.$defaultParts['arm_left'].'"
                        armRight="'.$defaultParts['arm_right'].'"
                        legLeft="'.$defaultParts['leg_left'].'"
                        legRight="'.$defaultParts['leg_right'].'"

                        headColor="#D3D3D3"
                        torsoColor="#D3D3D3"
                        armLeftColor="#D3D3D3"
                        armRightColor="#D3D3D3"
                        legLeftColor="#D3D3D3"
                        legRightColor="#D3D3D3"
                    >
                    </Humanoid>
                </Root>
            ';
        } else {
            $this->render_ulid = $this->file_ulid;
        }

        $this->save();
        return true;
    }

    public function grantTo(User $user, $isFree = false): bool|Inventory
    {
        if ($user) {
            $price = $this->price;
            if ($isFree == true) {
                $price = 0;
            }

            $user->decrement('currency', $price);
            $highest = Inventory::where('item_id', $this->id)
                                ->orderBy('serial', 'DESC')
                                ->first();
            $serial = $highest?->serial + 1 ?? 1;
    
            $inv = Inventory::create([
                'user_id' => $user->id,
                'item_id' => $this->id,
                'serial' => $serial
            ]);
            SaleLog::insert([
                'seller_id' => $this->creator_id,
                'buyer_id' => $user->id,
                'item_id' => $this->id,
                'price' => $price,
                'created_at' => now(),
            ]);

            return $inv;
        }

        return false;
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
        if ($this->available_to && $this->available_to->isPast())
            return false;
        if ($this->available_from && $this->available_from->isPast() && !$this->available_to)
            return false;

        return true;
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
        if ($this->isTradeable())
            return false;
        if (!$this->available_from?->isPast())
            return false;
        if ($this->available_to?->isPast())
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
