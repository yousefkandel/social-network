<?php

namespace App\Repositories;

use App\Models\FriendRequest;
use App\Repositories\Interfaces\FriendRepositoryInterface;

class FriendRepository implements FriendRepositoryInterface
{
    public function all()
    {
        return FriendRequest::all();
    }

    public function find($id)
    {
        return FriendRequest::findOrFail($id);
    }

    public function create(array $data)
    {
        return FriendRequest::create($data);
    }

    public function update(FriendRequest $friend, array $data)
    {
        $friend->update($data);
        return $friend;
    }

    public function delete(FriendRequest $friend)
    {
        return $friend->delete();
    }

    public function getPendingRequests($userId)
    {
        return FriendRequest::where('receiver_id', $userId)
                     ->where('status', 'pending')
                     ->get();
    }

    public function getFriends($userId)
    {
        return FriendRequest::where(function ($q) use ($userId) {
            $q->where('sender_id', $userId)
              ->orWhere('receiver_id', $userId);
        })->where('status', 'accepted')->get();
    }

    public function exists($senderId, $receiverId)
    {
        return FriendRequest::where('sender_id', $senderId)
                     ->where('receiver_id', $receiverId)
                     ->exists();
    }
}
