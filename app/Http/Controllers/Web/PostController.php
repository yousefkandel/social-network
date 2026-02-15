<?php
namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return view('posts.index', compact('posts'));
    }

   public function store(PostRequest $request)
{
    $userId = Auth::id();


    $this->postService->createPost(
        $request->validated(),
        $userId,
        $request->file('image') // تمرير الصورة للـ Service
    );

    return redirect()->back()->with('success', 'Post created successfully');
}

public function update(PostRequest $request, Post $post)
{
    $userId = Auth::id();

    $this->postService->updatePost(
        $post,
        $request->validated(),
        $userId,
        $request->file('image')
    );

    return redirect()->back()->with('success', 'Post updated successfully');
}

    public function destroy(Post $post)
    {
        $userId = Auth::id();


        $this->postService->deletePost($post,$userId);

        return redirect()->back();
    }
}
