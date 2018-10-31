<?php

namespace App\Providers;

use App\File;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('editable', function (File $file) {
            $security = $file->security;
            $user = auth()->user();

            if ($security == -1) {
                return true;
            } elseif (($security != -1) && $user != null) {
                return $user->id === $file->folder->user_id;
            } else {
                return false;
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
