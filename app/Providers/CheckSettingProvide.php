<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\RelatedNewSite;
use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Spatie\FlareClient\Api;

class CheckSettingProvide extends ServiceProvider
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
        $getSetting = Setting::firstOr(function(){
            return Setting::create([
                'site_name' => 'My Site',
                'logo' => '/img/logo.png',
                'favicon' => 'default',
                'email' => 'news@gmail.com',
                'facebook' => 'http://www.facebook.com/',
                'twitter' => 'http://www.twitter.com/',
                'instagram' => 'http://www.instagram.com/',
                'youtube' => 'http://www.youtube.com/',
                'country' => 'Egypt',
                'city' => 'Cairo',
                'street' => 'B3',
                'phone' => '11111',
            ]);
        });


        view()->share([
            'getSetting' => $getSetting,
        ]);
    }
}
