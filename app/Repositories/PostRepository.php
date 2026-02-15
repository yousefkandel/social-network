<?php
namespace App\Repositories;

use App\Models\Post;
use App\Repositories\InterFaces\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface{
 public function all(){
 return Post::with(['user.profile', 'comments.user', 'likes'])
            ->latest()
            ->get();
 }
 public function find($id){

return Post::findOrFail($id);
 }
 public function create(array $data){

return  Post::create($data);

 }
 public function update(Post $post, array $data){

return $post->update($data);

 }
 public function delete(Post $post){

return  $post->delete();

 }


}
