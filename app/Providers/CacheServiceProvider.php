<?php

namespace App\Providers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class CacheServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //read more posts
        if(!Cache::has('read_more_posts')){
            $read_more_posts = Post::active()->select('id', 'title' , 'slug')->latest()->limit(10)->get();
            Cache::remember('read_more_posts', 3600, function () use ($read_more_posts) {
                return $read_more_posts;
            });
        }
        $read_more_posts = Cache::get('read_more_posts');

        //latest posts
        if(!Cache::has('latest_posts')){
            $latest_posts = Post::active()->select('id', 'title','slug')->latest()->limit(5)->get();
            Cache::remember('latest_posts', 3600, function () use ($latest_posts) {
                return $latest_posts;
            });
            }
        $latest_posts = Cache::get('latest_posts');

        //greatest posts
        if(!Cache::has('greatest_posts_comments')){
           $greatest_posts_comments = Post::active()->withCount('comments')
            ->orderBy('comments_count', 'desc')
            ->take(5)
            ->get();
            Cache::remember('greatest_posts_comments', 3600, function () use ($greatest_posts_comments) {
                return $greatest_posts_comments;
            });
        }
        $greatest_posts_comments = Cache::get('greatest_posts_comments');


        view()->share([
            'read_more_posts' => $read_more_posts,
            'latest_posts' => $latest_posts,
            'greatest_posts_comments' => $greatest_posts_comments
        ]);
    }
}

