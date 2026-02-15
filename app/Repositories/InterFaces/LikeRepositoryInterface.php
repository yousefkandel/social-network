<?php

namespace App\Repositories\Interfaces;

use App\Models\Like;

interface LikeRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function delete(Like $like);
    public function exists(array $data); 
}
