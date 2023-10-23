<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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
            $permintaan = Submission::select('user_id', DB::raw('COUNT(*) as jumlah_pengajuan'))
                ->whereNotIn('status', ['finish', 'submit'])
                ->groupBy('user_id')
                ->get();

            $view->with('permintaan', $permintaan);
        });
    }
}
