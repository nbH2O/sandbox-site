<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserFriendship extends Model
{
    protected $fillable = ['sender_id', 'receiver_id', 'is_accepted'];

    // Sender relationship
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Receiver relationship
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
