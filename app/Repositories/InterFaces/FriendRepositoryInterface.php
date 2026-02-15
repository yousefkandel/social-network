<?php

namespace App\Repositories\Interfaces;

use App\Models\FriendRequest;

interface FriendRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update(FriendRequest $friend, array $data);
    public function delete(FriendRequest $friend);
    public function getPendingRequests($userId);
    public function getFriends($userId);
    public function exists($senderId, $receiverId);
}
