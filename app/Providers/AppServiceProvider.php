<?php

namespace App\Providers;

// use Illuminate\Contracts\Pagination\Paginator;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;

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
     * Membuat pagination agar menggunakan bootstrap
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

    /**
     * Membuat Gate untuk authorisasi user
     * Gate ini selalu menerima instance user sebagai argumen pertama dalam closure
     * Dan secara otomatis tau siapa user yg sedang login
     * Sehingga kita bisa mengatur 'kebebasan' akses
     */
        Gate::define('admin', function(User $user){

        //ini berarti, Gate ini hanya bisa diakses oleh user login dengan status is admin = true(1)
         return $user->is_admin;  

        });
    }
}
