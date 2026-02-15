<?php
namespace App\Services;

use App\Repositories\InterFaces\PostRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class PostService
{
    protected $PostRepository;

public function __construct(PostRepositoryInterface $postRepository )
{
    $this->PostRepository=$postRepository;
}
    public function getAll()
    {
    return $this->PostRepository->all();
    }
    public function findPost($id)
    {
    return $this->PostRepository->find($id);
    }

    public function createPost(array $data,$userId,$image = null)
    {
        if ($image) {
            $filename = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('posts', $filename, 'public');
            $data['image'] = $path;
        }

        $data['user_id'] = $userId;

    return $this->PostRepository->create($data);

    }


    public function updatePost($post, array $data,$userId,$image = null)
    {
        if ($post->user_id !== $userId) {
        abort(403, 'Unauthorized'); // يتأكد إن المستخدم صاحب البوست
        }

           if ($image) {
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
        return $this->PostRepository->update($post,$data);
        }
        }

        public function deletePost($post,$userId)
        {

        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }
        if ($post->user_id !== $userId) {
                abort(403, 'Unauthorized');
            }
        return $this->PostRepository->delete($post);
    }
}
