<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //

        // Check Email is exist 
        Validator::extend('is_email_exist', function ($attribute, $value, $parameters, $validator) {
            $user = User::where($attribute, $value)->first();
            if (!$user) {
                return false;
            }
            return true;
        });
    }
}
