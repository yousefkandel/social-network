<?php

namespace App\Repositories;

use App\Models\Like;
use App\Repositories\Interfaces\LikeRepositoryInterface;

class LikeRepository implements LikeRepositoryInterface
{
    public function all()
    {
        return Like::with(['user', 'post'])->latest()->get();
    }

    public function find($id)
    {
        return Like::findOrFail($id);
    }

    public function create(array $data)
    {
        return Like::create($data);
    }

    public function delete(Like $like)
    {
        return $like->delete();
    }

    public function exists(array $data)
    {
        return Like::where('user_id', $data['user_id'])
                   ->where('post_id', $data['post_id'])
                   ->exists();
    }
}
