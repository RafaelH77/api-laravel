<?php

namespace App\Providers;

use App\Repositories\Interfaces\{IPedidoRepository, IProdutoRepository, IVendedorRepository};
use App\Repositories\{PedidoRepository, ProdutoRepository, VendedorRepository};

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

        $this->app->bind(
            IPedidoRepository::class,
            PedidoRepository::class,
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
