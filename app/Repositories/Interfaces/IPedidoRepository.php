<?php

namespace App\Repositories\Interfaces;

interface IPedidoRepository extends IRepository
{
    public function getPedidosPorVendedor(int $vendedorId);
    public function getTotalPedidoPorDia($date);
}
