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

use App\Models\Item\Inventory;

use Mchev\Banhammer\Traits\Bannable;

use App\Models\Comment;

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
        $avatar = $this->avatar()->with(['items','face','head','torso','armLeft','armRight','legLeft','legRight'])->first();

        $result = (object) array("equipped", "properties");
        $result->equipped = [];
        $result->properties = [];

        // has to be a stupid thing like this
        // or @equipped is ignored
        $pe = fn ($v) => array_push($result->equipped, $v);
        $pe($avatar->face);
        $pe($avatar->head);
        $pe($avatar->torso);
        $pe($avatar->arm_left);
        $pe($avatar->arm_right);
        $pe($avatar->leg_left);
        $pe($avatar->leg_right);
        
        foreach ($avatar->items as $item) {
            array_push($result->equipped, $item);
        }

        $pp = fn ($n, $v) => $result->properties[$n] = $v;
        $pp('head_color', $avatar->head_color);
        $pp('torso_color', $avatar->torso_color);
        $pp('arm_left_color', $avatar->arm_left_color);
        $pp('arm_right_color', $avatar->arm_right_color);
        $pp('leg_left_color', $avatar->leg_left_color);
        $pp('leg_right_color', $avatar->leg_right_color);

        $result->properties = (object) $result->properties;

        return $result;
    }
    public function avatar(): BelongsTo
    {
        return $this->belongsTo(Avatar::class);
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

        return config('site.file_url').'/default/rendering.png';
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }


}
