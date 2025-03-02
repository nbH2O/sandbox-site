<?php

namespace App\Models\User;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Collection as BaseCollection;
use \Staudenmeir\LaravelMergedRelations\Eloquent\HasMergedRelationships;
use Illuminate\Database\Eloquent\Relations\MorphMany;

use Symfony\Component\Uid\Ulid;

use App\Models\Item\Inventory;
use App\Models\Comment;

use Mchev\Banhammer\Traits\Bannable;

use App\Jobs\RenderImage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasMergedRelationships, Bannable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['primaryRole'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'online_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

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

    public function getLink(): string
    {
        return url('/@'.$this->id);
    }

    public function getAvatar(): object
    {
        $avatar = $this->avatar()->with(['items.model', 'face','head','torso','armLeft','armRight','legLeft','legRight'])->first();

        $result = (object) array("equipped", "body", "properties");
        $result->equipped = [];
        $result->body = [];
        $result->properties = [];

        // has to be a stupid thing like this
        // or @equipped is ignored
        $pb = function ($n, $v) use ($result) { 
            if ($v != null) {
                $result->body[$n] = $v;
                array_push($result->equipped, $v);
            }
        };
        $pb('face', $avatar->face);
        $pb('head', $avatar->head);
        $pb('torso', $avatar->torso);
        $pb('arm_left', $avatar->armLeft);
        $pb('arm_right', $avatar->armRight);
        $pb('leg_left', $avatar->legLeft);
        $pb('leg_right', $avatar->legRight);
        
        foreach ($avatar->items as $item) {
            array_push($result->equipped, $item);
        }

        $pp = fn ($n, $v) => $result->properties[$n] = $v ?? '#D3D3D3';
        $pp('head_color', $avatar->head_color);
        $pp('torso_color', $avatar->torso_color);
        $pp('arm_left_color', $avatar->arm_left_color);
        $pp('arm_right_color', $avatar->arm_right_color);
        $pp('leg_left_color', $avatar->leg_left_color);
        $pp('leg_right_color', $avatar->leg_right_color);

        $result->body = (object) $result->body;
        $result->properties = (object) $result->properties;

        return $result;
    }
    public function avatar(): BelongsTo
    {
        return $this->belongsTo(Avatar::class);
    }

    public function doRender($isSync = false): bool|Ulid
    {
        $avatar = $this->getAvatar();

        $models = '';
        foreach ($avatar->equipped as $equippedItem) {
            $itemTypeIDs = array_flip(config('site.item_types'));
            if ($equippedItem->type->id == $itemTypeIDs['hat']) {
                $xml = $equippedItem->model->data;

                $doc = new \DOMDocument();
                $doc->loadXML($xml);
                $root = $doc->documentElement; // Get the first (root) element
                $root->setAttribute('position', (0+$equippedItem->pivot->position_x_adjust).','.(2+$equippedItem->pivot->position_y_adjust).','.(0+$equippedItem->pivot->position_z_adjust));
                $root->setAttribute('scale', ($equippedItem->pivot->scale ?? 1));
                $root->setAttribute('rotation', (0+$equippedItem->pivot->rotation_x).','.(0+$equippedItem->pivot->rotation_y).','.(0+$equippedItem->pivot->rotation_z));
    
                // Get all elements in the document
                $elements = $doc->getElementsByTagName('*');
    
                // Iterate over all elements and check for the 'src' attribute
                foreach ($elements as $element) {
                    if ($element->hasAttribute('src')) {
                        $element->setAttribute('src', url($element->getAttribute('src')));
                    }
                }
                
                $doc->formatOutput = false;
                $res = $doc->saveXML($root);
                // fix self-closing tag crap
                $models .=  preg_replace('/<(\w+)([^>]*?)\s*\/>/', '<$1$2></$1>', $res);
            }
        }

        $renderString = '
            <Root name="SceneRoot">
                <Humanoid
                    isRenderSubject="true"

                    face="'.( isset($avatar->body->face) ? url('storage/'.$avatar->body->face->file_ulid.'.png') : url('storage/default/rig/face.png') ).'"
                    head="'.( isset($avatar->body->head) ? url('storage/'.$avatar->body->head->file_ulid.'.obj') : url('storage/default/rig/head.obj') ).'"
                    torso="'.( isset($avatar->body->torso) ? url('storage/'.$avatar->body->torso->file_ulid.'.obj') : url('storage/default/rig/torso.obj') ).'"
                    armLeft="'.( isset($avatar->body->arm_left) ? url('storage/'.$avatar->body->arm_left->file_ulid.'.obj') : url('storage/default/rig/armLeft.obj') ).'"
                    armRight="'.( isset($avatar->body?->arm_right) ? url('storage/'.$avatar->body->arm_right->file_ulid.'.obj') : url('storage/default/rig/armRight.obj') ).'"
                    legLeft="'.( isset($avatar->body->leg_left) ? url('storage/'.$avatar->body->leg_left->file_ulid.'.obj') : url('storage/default/rig/legLeft.obj') ).'"
                    legRight="'.( isset($avatar->body->leg_right) ? url('storage/'.$avatar->body->leg_right->file_ulid.'.obj') : url('storage/default/rig/legRight.obj') ).'"

                    headColor="'.($avatar->properties->head_color ?? '#D3D3D3').'"
                    torsoColor="'.($avatar->properties->torso_color ?? '#D3D3D3').'"
                    armLeftColor="'.($avatar->properties->arm_left_color ?? '#D3D3D3').'"
                    armRightColor="'.($avatar->properties->arm_right_color ?? '#D3D3D3').'"
                    legLeftColor="'.($avatar->properties->leg_left_color ?? '#D3D3D3').'"
                    legRightColor="'.($avatar->properties->leg_right_color ?? '#D3D3D3').'"
                >
                    '.$models.'
                </Humanoid>
            </Root>
        ';

        if (!$isSync) {
            RenderImage::dispatch($this, $renderString);
            return true;
        } else {
            RenderImage::dispatchSync($this, $renderString);
            return true;
        }
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->orderBy('power', 'DESC')->where('is_public', true);
    }
    public function primaryRole(): HasOneThrough
    {
        return $this->hasOneThrough(
            Role::class,
            UserRole::class,
            'user_id', // r
            'id', // ur
            'id', // r
            'role_id' // ur
        )->orderBy('power', 'DESC')->where('is_public', true);
    }
    public function anyRoles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->orderBy('power', 'DESC');
    }

    public function isAdmin(): bool
    {
        $highestRole = $this->anyRoles()->first();

        if ($highestRole->power >= config('site.panel_access_min_power')) {
            return true;
        } else {
            return false;
        }
    }

    public function hasPanelAccess(): bool
    {
        if (!$res = $this->anyRoles()->first())
            return false;
        if ($res->power < config('site.panel_access_min_power'))
            return false;

        return true;
    }

    public function inventory(): hasMany
    {
        return $this->hasMany(Inventory::class)->orderBy('id', 'DESC');
    }

    public function friendsTo(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_friendships', 'sender_id', 'receiver_id')
            ->withPivot('is_accepted')
            ->withTimestamps();
    }
    public function friendsFrom(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_friendships', 'receiver_id', 'sender_id')
            ->withPivot('is_accepted')
            ->withTimestamps();
    }
    public function pendingFriendsTo()
    {
        return $this->friendsTo()->wherePivot('is_accepted', false);
    }
    public function pendingFriendsFrom()
    {
        return $this->friendsFrom()->wherePivot('is_accepted', false);
    }
    public function acceptedFriendsTo()
    {
        return $this->friendsTo()->wherePivot('is_accepted', true);
    }
    public function acceptedFriendsFrom()
    {
        return $this->friendsFrom()->wherePivot('is_accepted', true);
    }
    public function friends(): \Staudenmeir\LaravelMergedRelations\Eloquent\Relations\MergedRelation
    {
        return $this->mergedRelationWithModel(User::class, 'friends_view');
    }

    /**
     * get the user's render url
     *
     * @return string
     */
    public function getRender(): string
    {   
        if ($this->render_ulid)
            return config('site.file_url').'/'.$this->render_ulid.'.png';

        return config('site.file_url').'/default/user_rendering.png';
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }


}
