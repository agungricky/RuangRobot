<?php

namespace App\Providers;

use App\Models\akun;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
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
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $id = isset(Auth::user()->id) ? Auth::user()->id : null;
            $dataLogin = akun::where('akun.id', $id)
            ->join('profile', 'profile.id', 'akun.id')
            ->first();
            $view->with('dataLogin', $dataLogin);

        });
    }
}
