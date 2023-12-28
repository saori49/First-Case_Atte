<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Features;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Specify the action to create new users
        Fortify::createUsersUsing(CreateNewUser::class);

        // Specify the custom register view
        Fortify::registerView(function () {
            return view('auth.register');
        });

        // Specify the custom login view
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // Rate limiter for login attempts
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;
            return Limit::perMinute(10)->by($email . $request->ip());
        });

        // Specify the custom verify email view if email verification is enabled
        if (Features::enabled(Features::emailVerification())) {
            Fortify::verifyEmailView(function () {
                return view('auth.verify-email');
            });
        }
    }

}
