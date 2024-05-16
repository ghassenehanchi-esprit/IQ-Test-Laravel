<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\User;
use App\Models\Exchange;
use App\Models\Frontend;
use App\Models\Language;
use App\Constants\Status;
use App\Models\Withdrawal;
use App\Models\SupportTicket;
use App\Models\AdminNotification;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider {

    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        if (!Admin::where('email', 'admin@admin.com')->exists()) {
            // Create admin user
            Admin::create([
                'name' => 'Admin User',
                'email' => 'admin@admin.com',

                'password' => Hash::make('admin'), // Change 'password' to desired password
            ]);
        }


        $general        = gs();
        $viewShare['general']            = $general;
        $viewShare['emptyMessage']       = 'Data not found';

        view()->share($viewShare);

        view()->composer('admin.partials.sidenav', function ($view) {
            $view->with([

            ]);
        });

        view()->composer('admin.partials.topnav', function ($view) {
            $view->with([
            ]);
        });


        view()->composer('partials.seo', function ($view) {

        });




        Paginator::useBootstrapFour();
    }
}
