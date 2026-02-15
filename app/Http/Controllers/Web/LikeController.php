<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\LikeService;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    protected $likeService;

    public function __construct(LikeService $likeService)
    {
        $this->likeService = $likeService;
    }

    public function toggle($postId)
    {
        $userId = Auth::id(); // Session auth موجود في Blade
        $this->likeService->toggleLike($postId, $userId);

        return redirect()->back();
    }
}
