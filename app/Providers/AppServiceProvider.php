<?php

namespace App\Providers;

use App\Domain\Irpf\Contracts\TaxTableRepositoryInterface;
use App\Infrastructure\Irpf\FileTaxTableRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TaxTableRepositoryInterface::class, FileTaxTableRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
