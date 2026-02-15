<?php

namespace App\Repositories\Interfaces;

use App\Models\Comment;

interface CommentRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update(Comment $comment, array $data);
    public function delete(Comment $comment);
}
