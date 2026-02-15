<?php

namespace App\Providers;

use App\Models\Profile;
use App\Repositories\CommentRepository;
use App\Repositories\FriendRepository;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\FriendRepositoryInterface;
use App\Repositories\Interfaces\LikeRepositoryInterface;
use App\Repositories\InterFaces\PostRepositoryInterface;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use App\Repositories\LikeRepository;
use App\Repositories\PostRepository;
use App\Repositories\ProfileRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
            $this->app->bind(
        PostRepositoryInterface::class,
        PostRepository::class

    );
            $this->app->bind(
       CommentRepositoryInterface::class,
        CommentRepository::class

    );
            $this->app->bind(
       LikeRepositoryInterface::class,
        LikeRepository::class

    );
            $this->app->bind(
       FriendRepositoryInterface::class,
        FriendRepository::class

    );
            $this->app->bind(
       ProfileRepositoryInterface::class,
        ProfileRepository::class

    );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
