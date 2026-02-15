<?php

namespace App\Http\Controllers\Web;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    // إنشاء تعليق
    public function store(CommentRequest $request, Post $post)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['post_id'] = $post->id;

        $comment = $this->commentService->createComment($data);

        return ApiResponse::success(new CommentResource($comment));
    }

    // حذف تعليق
    public function destroy(Comment $comment)
    {
        // فقط صاحب التعليق يمكنه الحذف
        if ($comment->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        $this->commentService->deleteComment($comment);

        return response()->json([
            'message' => 'Comment deleted successfully'
        ]);
    }

    // عرض التعليقات الخاصة بمنشور معين
    public function index(Post $post)
    {
        $comments = $post->comments()->with('user')->latest()->get();
        return ApiResponse::success(CommentResource::collection($comments));
    }
}
