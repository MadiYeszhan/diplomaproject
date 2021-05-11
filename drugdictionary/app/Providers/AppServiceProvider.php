<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
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

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        if(Cookie::get('lang') == null) {
            Cookie::queue('lang', 1, 60 * 60 * 30);
        }

        view()->composer('*', function ($view)
        {
            if (Cookie::get('lang') == 1){
                App::setLocale('en');
            }
            else if (Cookie::get('lang') == 2){
                App::setLocale('ru');
            }
            else if (Cookie::get('lang') == 3){
                App::setLocale('kz');
            }

            if (!Auth::guest()){
                if (Auth::user()->mute != null){
                    $now = Carbon::now();
                    $mute_time = Carbon::parse(Auth::user()->mute->mute_time);
                    if ($mute_time->lt($now)){
                        Auth::user()->mute->delete();
                    }
                }
            }
        });
    }
}
