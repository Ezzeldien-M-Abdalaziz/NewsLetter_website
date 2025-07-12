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

        view()->share([
            'relatedSites' => $relatedSites,
            'categories' => $categories,
        ]);
    }
}
