<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
/**
 * Class PostController
 *
 * @group Posts
 *
 * APIs for managing posts
 */
class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index()
    {
        $posts = $this->postService->getAll();

        return ApiResponse::success(PostResource::collection($posts), 'Posts retrieved successfully', 200);

    }

    // POST /api/posts
public function store(PostRequest $request)
{


    $post = $this->postService->createPost(
        $request->validated(),
        Auth::id(),
        $request->file('image')
    );

                return ApiResponse::success(new PostResource($post), 'Post created successfully', 201);


}

public function update(PostRequest $request, Post $post)
{

    $this->postService->updatePost(
        $post,
        $request->validated(),
        Auth::id(),
        $request->file('image')
    );

return ApiResponse::success(new PostResource($post->fresh()), 'Post updated successfully', 200);

}

    public function destroy(Post $post)
    {
        $this->postService->deletePost(
            $post,
            Auth::id()
        );

   return ApiResponse::success(null, 'Post deleted successfully', 200);

    }
}
