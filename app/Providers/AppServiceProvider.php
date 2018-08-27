<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->face_templete();
    }
    
    protected function face_templete(){
        $this->app->singleton('face_templete',function($app){
            return function ($age = null){
                 $templete = array(
                     2 => base_path('resources/views/web/images/camera_2.png'),
                     4 => base_path('resources/views/web/images/camera_3.png'),
                     6 => base_path('resources/views/web/images/camera_4.png'),
                     8 => base_path('resources/views/web/images/camera_5.png'),
                     10 => base_path('resources/views/web/images/camera_6.png'),
                 );
                 
                 if($age){
                    return  $templete[$age];
                 }
                 
                 return $templete;
            };
        });
    }
    
    
}
