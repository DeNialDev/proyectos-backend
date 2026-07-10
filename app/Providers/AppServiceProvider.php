<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\NotificationRepositoryInterface;
use App\Repositories\Eloquent\NotificationRepository;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
        \App\Repositories\ProjectRepositoryInterface::class,
        \App\Repositories\Eloquent\ProjectRepository::class);
        $this->app->bind(
            \App\Repositories\TaskRepositoryInterface::class,
            \App\Repositories\Eloquent\TaskRepository::class
        );
        $this->app->bind(
            \App\Repositories\UserRepositoryInterface::class,
            \App\Repositories\Eloquent\UserRepository::class
        );

        $this->app->bind(
            NotificationRepositoryInterface::class,
            NotificationRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
