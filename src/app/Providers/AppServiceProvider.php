<?php

namespace App\Providers;

use App\Repositories\BookRepositoryInterface;
use App\Repositories\ClientRepositoryInterface;
use App\Repositories\Eloquent\EloquentClientRepository;
use App\Repositories\Eloquent\EloquentBookRepository;
use App\Services\Book\BookService;
use App\Services\Client\ClientService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(BookRepositoryInterface::class, EloquentBookRepository::class);
        $this->app->bind(ClientRepositoryInterface::class, EloquentClientRepository::class);


        $this->app->bind(BookService::class, function ($app) {
            return new BookService(
                $app->make(BookRepositoryInterface::class),
                $app->make(ClientRepositoryInterface::class)
            );
        });

        $this->app->bind(ClientService::class, function ($app) {
            return new ClientService(
                $app->make(ClientRepositoryInterface::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
