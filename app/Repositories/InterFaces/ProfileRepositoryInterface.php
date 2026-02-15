<?php

namespace App\Repositories\Interfaces;

interface ProfileRepositoryInterface
{
    public function getProfileByUserId(int $userId);
    public function createProfile(array $data);
    public function updateProfile(int $userId, array $data);
}
