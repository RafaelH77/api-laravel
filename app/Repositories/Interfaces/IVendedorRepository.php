<?php

namespace App\Repositories\Interfaces;

interface IVendedorRepository extends IRepository
{
    public function getPedidosById(int $id);
    public function getVendedoresComissao();
}
