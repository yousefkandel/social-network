<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Web\CommentController;
use App\Http\Controllers\Web\FriendController;
use App\Http\Controllers\Web\LikeController;
use App\Http\Controllers\Web\PostController;
use App\Models\User;
use App\Notifications\FriendRequestNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', [PostController::class, 'index'])->name('home');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
Route::middleware('auth')->group(function () {


    Route::resource('post',  PostController::class);

    Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    Route::get('posts/{post}/like', [LikeController::class, 'toggle'])->name('posts.like');
    Route::get('friends', [FriendController::class, 'index'])->name('friends.index');
    Route::post('friends/send/{id}', [FriendController::class, 'send'])->name('friends.send');
    Route::post('friends/respond/{friend}/{status}', [FriendController::class, 'respond'])->name('friends.respond');
});
Route::get('/send-friend-request/{id}', function($id) {
    $receiver = User::findOrFail($id);
    $sender = Auth::user();

    $receiver->notify(new FriendRequestNotification($sender));

    return "Friend request notification sent!";
})->middleware('auth');


Route::get('/send-friend-request/{id}', function($id) {
    $receiver = User::findOrFail($id);
    $sender = Auth::user();

    $receiver->notify(new FriendRequestNotification($sender));

    return "Friend request notification sent!";
})->middleware('auth');
Route::get('/users/search', [UserController::class, 'search'])->name('users.search');

require __DIR__.'/auth.php';
