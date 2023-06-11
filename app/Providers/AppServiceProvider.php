<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\Submission;
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
        view()->composer('*', function ($view) {
            $view->with('setting', Setting::first());
        });
        view()->composer('*', function ($view) {
            $view->with(
                'permintaan',
                Submission::select('user_id')
                    ->where('status', '!=', 'finish')
                    ->where('status', '!=', 'submit')
                    ->groupBy('user_id')
                    ->count('user_id')
            );
        });
    }
}
