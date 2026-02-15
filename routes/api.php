<?php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\FriendController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return 'API';
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('posts', PostController::class);
    Route::get('comments', [CommentController::class, 'index']);
    Route::post('posts/{post}/comments', [CommentController::class, 'store']);
    Route::delete('comments/{comment}', [CommentController::class, 'destroy']);
    Route::get('/posts/{post}/like', [LikeController::class, 'toggle']);

    // إرسال طلب صداقة
    Route::post('friends/send/{user}', [FriendController::class, 'send']);

    // الرد على طلب صداقة
    Route::post('friends/respond/{friendRequest}/{status}', [FriendController::class, 'respond']);

    // قائمة الطلبات المعلقة
    Route::get('friends/pending', [FriendController::class, 'pendingRequests']);

    // قائمة الأصدقاء (accepted)
    Route::get('friends', [FriendController::class, 'friends']);
});

