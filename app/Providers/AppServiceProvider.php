<?php

namespace App\Providers;

use App\Contracts\Repositories\CategoryRepositoryInterface;
use App\Contracts\Repositories\ListingRepositoryInterface;
use App\Contracts\Repositories\RentalRepositoryInterface;
use App\Contracts\Repositories\RequestRepositoryInterface;
use App\Contracts\Services\CategoryServiceInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\AuthServiceInterface;
use App\Contracts\Services\ImgurServiceInterface;
use App\Contracts\Services\ListingServiceInterface;
use App\Contracts\Services\RentalServiceInterface;
use App\Contracts\Services\RequestServiceInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\ListingRepository;
use App\Repositories\RentalRepository;
use App\Repositories\RequestRepository;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\CategoryService;
use App\Services\ImgurService;
use App\Services\ListingService;
use App\Services\RentalService;
use App\Services\RequestService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(ImgurServiceInterface::class, ImgurService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
        $this->app->bind(ListingRepositoryInterface::class, ListingRepository::class);
        $this->app->bind(ListingServiceInterface::class, ListingService::class);
        $this->app->bind(RequestRepositoryInterface::class, RequestRepository::class);
        $this->app->bind(RequestServiceInterface::class, RequestService::class);
        $this->app->bind(RentalRepositoryInterface::class, RentalRepository::class);
        $this->app->bind(RentalServiceInterface::class, RentalService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
