<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Profile;
use App\Models\FriendRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
public function run(): void
{
    // Create 10 Users
    User::factory(10)->create()->each(function ($user) {

        // Profile
        Profile::factory()->create([
            'user_id' => $user->id
        ]);

        // Each user has 3 posts
        Post::factory(3)->create([
            'user_id' => $user->id
        ])->each(function ($post) use ($user) {

            // Each post has 2 comments
            Comment::factory(2)->create([
                'post_id' => $post->id,
                'user_id' => User::inRandomOrder()->first()->id
            ]);

            // Each post has random likes
         $users = User::inRandomOrder()->take(rand(1,3))->get();

foreach ($users as $randomUser) {
    Like::create([
        'post_id' => $post->id,
        'user_id' => $randomUser->id,
    ]);
}


        });
    });

    // Friend Requests
    FriendRequest::factory(10)->create();
}
}
