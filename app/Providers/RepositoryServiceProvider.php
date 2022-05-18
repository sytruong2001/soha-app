<?php

namespace App\Providers;

use App\Repositories\InfoUser\InfoUserRepository;
use App\Repositories\InfoUser\InfoUserRepositoryInterface;
use App\Repositories\KC\KCRepository;
use App\Repositories\KC\KCRepositoryInterface;
use App\Repositories\Locked\LockedRepository;
use App\Repositories\Locked\LockedRepositoryInterface;
use App\Repositories\LogCoin\LogCoinRepository;
use App\Repositories\LogCoin\LogCoinRepositoryInterface;
use App\Repositories\LogKC\LogKCRepository;
use App\Repositories\LogKC\LogKCRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
        $this->app->bind(
            InfoUserRepositoryInterface::class,
            InfoUserRepository::class
        );
        $this->app->bind(
            KCRepositoryInterface::class,
            KCRepository::class
        );
        $this->app->bind(
            LockedRepositoryInterface::class,
            LockedRepository::class
        );
        $this->app->bind(
            LogCoinRepositoryInterface::class,
            LogCoinRepository::class
        );
        $this->app->bind(
            LogKCRepositoryInterface::class,
            LogKCRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}