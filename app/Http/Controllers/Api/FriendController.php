<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\FriendResource;
use App\Models\FriendRequest;
use App\Services\FriendService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    protected $friendService;

    public function __construct(FriendService $friendService)
    {
        $this->friendService = $friendService;
    }

    // إرسال طلب صداقة
    public function send($receiverId)
    {
        $friendRequest = $this->friendService->sendRequest(Auth::id(), $receiverId);

        if (!$friendRequest) {
            return response()->json([
                'message' => 'Friend request already exists.'
            ], 409);
        }

        return ApiResponse::success(new FriendResource($friendRequest));
    }

    // الرد على طلب صداقة (accept/decline)
    public function respond(FriendRequest $friendRequest, $status)
    {
        if (!in_array($status, ['accepted', 'declined'])) {
            return response()->json([
                'message' => 'Invalid status'
            ], 400);
        }

        $updatedRequest = $this->friendService->respondRequest($friendRequest, $status);

        return ApiResponse::success(new FriendResource($updatedRequest));
    }

    // عرض الطلبات المعلقة
    public function pendingRequests()
    {
        $requests = $this->friendService->getPendingRequests(Auth::id());
        return ApiResponse::success(FriendResource::collection($requests));
    }

    // عرض الأصدقاء (accepted)
    public function friends()
    {
        $friends = $this->friendService->getFriends(Auth::id());
        return ApiResponse::success(FriendResource::collection($friends));
    }
}
