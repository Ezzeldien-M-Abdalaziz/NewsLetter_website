<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use App\Models\RelatedNewSite;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
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

        //share related sites
        $relatedSites = RelatedNewSite::select('name', 'url')->get();
        $categories = Category::select('slug', 'id', 'name')->get();

        /************************CACHE **************************/

        //  Cache::forget('latest_posts');
        //  Cache::forget('greatest_posts_comments');

        if(!Cache::has('latest_posts')){
            $latest_posts = Post::active()->select('id', 'title','slug')->latest()->limit(5)->get();
            Cache::remember('latest_posts', 3600, function () use ($latest_posts) {
                return $latest_posts;
            });
        }

        if(!Cache::has('greatest_posts_comments')){
           $greatest_posts_comments = Post::active()->withCount('comments')
            ->orderBy('comments_count', 'desc')
            ->take(5)
            ->get();
            Cache::remember('greatest_posts_comments', 3600, function () use ($greatest_posts_comments) {
                return $greatest_posts_comments;
            });
        }


        $latest_posts = Cache::get('latest_posts');
        $greatest_posts_comments = Cache::get('greatest_posts_comments');


        view()->share([
            'relatedSites' => $relatedSites,
            'categories' => $categories,
            'latest_posts' => $latest_posts,
            'greatest_posts_comments' => $greatest_posts_comments
        ]);
    }
}
