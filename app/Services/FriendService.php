<?php

namespace App\Services;

use App\Repositories\Interfaces\FriendRepositoryInterface;
use App\Models\FriendRequest;

class FriendService
{
    protected $friendRepository;

    public function __construct(FriendRepositoryInterface $friendRepository)
    {
        $this->friendRepository = $friendRepository;
    }

    public function sendRequest($senderId, $receiverId)
    {
        if ($this->friendRepository->exists($senderId, $receiverId)) {
            return null; // الطلب موجود
        }

        return $this->friendRepository->create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'status' => 'pending'
        ]);
    }

    public function respondRequest(FriendRequest $friend, $status)
    {
        return $this->friendRepository->update($friend, ['status' => $status]);
    }

    public function getPendingRequests($userId)
    {
        return $this->friendRepository->getPendingRequests($userId);
    }

    public function getFriends($userId)
    {
        return $this->friendRepository->getFriends($userId);
    }
}
