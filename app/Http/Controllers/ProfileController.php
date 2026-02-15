<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    // صفحة تعديل البروفايل
    public function edit()
    {
        $userId = Auth::id();

        $profile = $this->profileService->getProfile();

        // إنشاء profile تلقائي لو ما فيش
        if (!$profile) {
            $profile = $this->profileService->createProfile([
                'user_id' => $userId,
                'bio' => '',
                'profile_picture' => null,
            ]);
        }

        return view('profile.edit', compact('profile'));
    }

    // تحديث البروفايل
    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();

        if ($user) {
            $user->name = $request->name;
            $user->save();
        }

        $data = ['bio' => $request->bio];

        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $request->file('profile_picture');
        }

        $this->profileService->updateProfile($data);

        return back()->with('success', 'تم تحديث البروفايل بنجاح');
    }
}
