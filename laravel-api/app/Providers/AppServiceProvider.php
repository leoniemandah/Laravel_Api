<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Admin\Repositories\AdminRepositoryInterface;
use App\Domain\Profile\Repositories\ProfileRepositoryInterface;
use App\Domain\Profile\Services\ProfileServiceInterface;
use App\Infrastructure\Admin\Repositories\AdminRepository;
use App\Infrastructure\Profile\Repositories\ProfileRepository;
use App\Infrastructure\Profile\Services\ProfileService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
        $this->app->bind(ProfileServiceInterface::class, ProfileService::class);
        $this->app->bind(ProfileRepositoryInterface::class, ProfileRepository::class);
        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
