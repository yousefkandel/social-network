<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\LikeResource;
use App\Services\LikeService;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    protected $likeService;

    public function __construct(LikeService $likeService)
    {
        $this->likeService = $likeService;
    }

    // Toggle like/unlike
    public function toggle($postId, Request $request)
    {
        $userId = $request->user()->id; // auth من Sanctum token
        $liked = $this->likeService->toggleLike($postId, $userId);

        return response()->json([
            'success' => true,
            'liked' => $liked['liked'], // true لو صار like, false لو تم un-like
            'like' => $liked['like'] ? ApiResponse::success(new LikeResource($liked['like'])) : null
        ]);
    }

    // عرض كل الإعجابات لمنشور معين
    public function index($postId)
    {
        $likes = $this->likeService->getAll($postId);

        return ApiResponse::success(LikeResource::collection($likes));
    }
}
