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
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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
        Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });



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
