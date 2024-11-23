<?php

namespace App\Providers;

use App\Repositories\Interfaces\MealRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\ReservationRepositoryInterface;
use App\Repositories\Interfaces\TableRepositoryInterface;
use App\Repositories\Interfaces\WaitingListRepositoryInterface;
use App\Repositories\MealRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ReservationRepository;
use App\Repositories\TableRepository;
use App\Repositories\WaitingListRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TableRepositoryInterface::class, TableRepository::class);
        $this->app->bind(ReservationRepositoryInterface::class, ReservationRepository::class);
        $this->app->bind(WaitingListRepositoryInterface::class, WaitingListRepository::class);
        $this->app->bind(MealRepositoryInterface::class, MealRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
