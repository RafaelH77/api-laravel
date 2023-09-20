<?php

namespace App\Services;

use App\Repositories\Interfaces\IVendedorRepository;

class VendedorService extends BaseService
{
    public function __construct(IVendedorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getVendedoresComissao()
    {
        return $this->repository->getVendedoresComissao();
    }

    public function getPedidosById(int $id)
    {
        return $this->repository->getPedidosById($id);
    }
}
