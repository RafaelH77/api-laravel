<?php

namespace App\Services;

use App\Repositories\Interfaces\IVendedorRepository;

class VendedorService extends BaseService
{
    protected $repository;

    public function __construct(IVendedorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getPedidosById(int $id)
    {
        return $this->repository->getPedidosById($id);
    }
}
