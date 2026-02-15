<?php

namespace App\Services;

use App\Repositories\Interfaces\LikeRepositoryInterface;
use App\Models\Like;

class LikeService
{
    protected $likeRepository;

    public function __construct(LikeRepositoryInterface $likeRepository)
    {
        $this->likeRepository = $likeRepository;
    }

    public function getAll()
    {
        return $this->likeRepository->all();
    }

    // ترتيب arguments: $postId أولًا، $userId ثانيًا
    public function toggleLike($postId, $userId)
    {
        $data = ['user_id' => $userId, 'post_id' => $postId];

        if ($this->likeRepository->exists($data)) {
            // موجود بالفعل، نحذفه
            $like = Like::where($data)->first();
            $this->likeRepository->delete($like);
            return ['liked' => false];
        } else {
            // مش موجود، نضيفه
            $like = $this->likeRepository->create($data);
            return ['liked' => true];
        }
    }
}
