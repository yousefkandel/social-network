<?php

namespace App\Services;

use App\Repositories\Interfaces\ProfileRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    protected $profileRepo;

    public function __construct(ProfileRepositoryInterface $profileRepo)
    {
        $this->profileRepo = $profileRepo;
    }

    // جلب profile الحالي
    public function getProfile()
    {
        $userId = Auth::id();
        return $this->profileRepo->getProfileByUserId($userId);
    }

    // إنشاء profile جديد
    public function createProfile(array $data)
    {
        return $this->profileRepo->createProfile($data);
    }

    // تحديث profile
    public function updateProfile(array $data)
    {
        $userId = Auth::id();
        $profile = $this->profileRepo->getProfileByUserId($userId);

        // حذف الصورة القديمة لو موجودة
        if (isset($data['profile_picture']) && $profile && $profile->profile_picture) {
            if (Storage::disk('public')->exists($profile->profile_picture)) {
                Storage::disk('public')->delete($profile->profile_picture);
            }
        }

        // تخزين الصورة الجديدة
        if (isset($data['profile_picture'])) {
            $data['profile_picture'] = $data['profile_picture']->store('profile_pictures', 'public');
        }

        return $this->profileRepo->updateProfile($userId, $data);
    }
}
