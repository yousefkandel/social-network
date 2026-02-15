<?php

namespace App\Repositories;

use App\Models\Profile;
use App\Repositories\Interfaces\ProfileRepositoryInterface;

class ProfileRepository implements ProfileRepositoryInterface
{
    public function getProfileByUserId(int $userId)
    {
        return Profile::where('user_id', $userId)->first();
    }

    public function createProfile(array $data)
    {
        return Profile::create($data);
    }

    public function updateProfile(int $userId, array $data)
    {
        $profile = Profile::where('user_id', $userId)->first();

        if ($profile) {
            $profile->update($data);
        }

        return $profile;
    }
}
