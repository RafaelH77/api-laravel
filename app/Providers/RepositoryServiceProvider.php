<?php

namespace App\Providers;

use App\Repositories\Interfaces\{
    IProdutoRepository,
};
use App\Repositories\{
    ProdutoRepository,
};

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            IProdutoRepository::class,
            ProdutoRepository::class,
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
