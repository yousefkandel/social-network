<?php

namespace App\Services;

use App\Repositories\Interfaces\CommentRepositoryInterface;

class CommentService
{
    protected $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function getAll()
    {
        return $this->commentRepository->all();
    }

    public function findComment($id)
    {
        return $this->commentRepository->find($id);
    }

    public function createComment(array $data)
    {
        return $this->commentRepository->create($data);
    }

    public function updateComment($comment, array $data)
    {
        return $this->commentRepository->update($comment, $data);
    }

    public function deleteComment($comment)
    {
        return $this->commentRepository->delete($comment);
    }
}
