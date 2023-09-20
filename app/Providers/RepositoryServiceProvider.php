<?php

namespace App\Providers;

use App\Repositories\Interfaces\{IPedidoRepository,
    IProdutoRepository,
    IRepository,
    IUserRepository,
    IVendedorRepository};
use App\Repositories\{BaseRepository, PedidoRepository, ProdutoRepository, UserRepository, VendedorRepository};

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

        $this->app->bind(
            IUserRepository::class,
            UserRepository::class,
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
