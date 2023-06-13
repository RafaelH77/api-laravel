<?php

namespace App\Repositories\Interfaces;

interface IPedidoRepository extends IRepository
{
    public function getTotalPedidoPorDia($date);
}
