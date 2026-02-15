<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\FriendService;
use App\Models\FriendRequest;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    protected $friendService;

    public function __construct(FriendService $friendService)
    {
        $this->friendService = $friendService;
    }

    public function index()
    {
        $userId = Auth::id();
        $friends = $this->friendService->getFriends($userId);
        $pending = $this->friendService->getPendingRequests($userId);

        return view('friends.index', compact('friends', 'pending'));
    }

    public function send($receiverId)
    {
        $this->friendService->sendRequest(Auth::id(), $receiverId);
        return redirect()->back();
    }

    public function respond(FriendRequest $friend, $status)
    {
        $this->friendService->respondRequest($friend, $status);
        return redirect()->back();
    }
}
