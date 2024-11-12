<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\RepositoryProviderInterface;
use App\Services\GithubRepositoryProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(RepositoryProviderInterface::class, GithubRepositoryProvider::class);
    }

    public function boot(): void
    {
        //
    }
}
