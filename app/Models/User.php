<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function profile()
{
    return $this->hasOne(Profile::class);
}

public function posts()
{
    return $this->hasMany(Post::class);
}

public function comments()
{
    return $this->hasMany(Comment::class);
}

public function likes()
{
    return $this->hasMany(Like::class);
}
public function sentFriendRequests()
{
    return $this->hasMany(FriendRequest::class, 'sender_id');
}

public function receivedFriendRequests()
{
    return $this->hasMany(FriendRequest::class, 'receiver_id');
}
// هل أنا وصديق؟
public function isFriendWith($userId)
{
    return FriendRequest::where(function ($q) use ($userId) {
        $q->where('sender_id', $this->id)->where('receiver_id', $userId)
          ->orWhere('sender_id', $userId)->where('receiver_id', $this->id);
    })->where('status', 'accepted')->exists();
}

// هل بعثت طلب صداقة ولسه Pending؟
public function hasPendingRequest($userId)
{
    return FriendRequest::where('sender_id', $this->id)
             ->where('receiver_id', $userId)
             ->where('status', 'pending')->exists();
}

// هل جالي طلب صداقة ولسه Pending؟
public function hasReceivedRequest($userId)
{
    return FriendRequest::where('sender_id', $userId)
             ->where('receiver_id', $this->id)
             ->where('status', 'pending')->exists();
}

}
