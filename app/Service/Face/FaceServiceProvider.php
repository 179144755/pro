<?php

namespace App\Service\Face;

use Illuminate\Support\ServiceProvider;


class FaceServiceProvider extends ServiceProvider
{   
    
     protected $defer = true;
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {   
        $this->app->singleton('face', function ($app) {
            return new Face(config('face'));
        });
    }
    
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['face'];
    }
}
