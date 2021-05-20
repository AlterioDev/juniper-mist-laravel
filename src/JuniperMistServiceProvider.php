<?php 

namespace Basduchambre\JuniperMist;

use Illuminate\Support\ServiceProvider;

class JuniperMistServiceProvider extends ServiceProvider 
{
    
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/junipermist.php' => config_path('junipermist.php')
        ]);
    }

    public function register()
    {
        $this->app->singleton('JuniperMist', function($app) {
            return new JuniperMist();
        });
    }

}