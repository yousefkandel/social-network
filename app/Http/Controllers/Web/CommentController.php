<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function store(CommentRequest $request, Post $post)
    {


        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['post_id'] = $post->id;

        $this->commentService->createComment($data);

        return redirect()->back()->with('success', 'Comment added successfully');
    }

    public function destroy(Comment $comment)
    {
        // Optional: فقط صاحب التعليق يقدر يحذفه
        if ($comment->user_id !== Auth::id()) {
            abort(403);
        }

        $this->commentService->deleteComment($comment);

        return redirect()->back();
    }
}
