<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

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
        Setting::firstOr(function(){
            return Setting::create([
                'site_name' => 'My Site',
                'logo' => 'default',
                'favicon' => 'default',
                'email' => 'news@gmail.com',
                'facebook' => 'default',
                'twitter' => 'default',
                'instagram' => 'default',
                'youtupe' => 'default',
                'country' => 'default country',
                'city' => 'default city',
                'street' => 'default street',
                'phone' => '11111',
            ]);
        });
    }
}
