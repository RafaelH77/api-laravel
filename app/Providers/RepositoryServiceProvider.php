<?php

namespace App\Providers;

use App\Repositories\Interfaces\{IProdutoRepository, IVendedorRepository};
use App\Repositories\{ProdutoRepository, VendedorRepository};

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

        $this->app->bind(
            IVendedorRepository::class,
            VendedorRepository::class,
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
