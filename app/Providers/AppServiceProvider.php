<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\User\UserRepositoryImplement;
use App\Repositories\User\UserRepository;


use App\Repositories\Buku\BukuRepositoryImplement;
use App\Repositories\Buku\BukuRepository;
use App\Services\User\UserService;
use App\Services\User\UserServiceImplement;
use App\Services\Buku\BukuService;
use App\Services\Buku\BukuServiceImplement;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepository::class,UserRepositoryImplement::class);
        $this->app->bind(BukuRepository::class,BukuRepositoryImplement::class);
        $this->app->bind(UserService::class,UserServiceImplement::class);
        $this->app->bind(BukuService::class,BukuServiceImplement::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
