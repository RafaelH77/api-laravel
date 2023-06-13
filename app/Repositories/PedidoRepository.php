<?php

namespace App\Repositories;

use App\Repositories\Interfaces\IPedidoRepository;
use App\Models\Pedido;
use Illuminate\Support\Facades\DB;

class PedidoRepository extends BaseRepository implements IPedidoRepository
{
    protected $entity;

    public function __construct(Pedido $entity)
    {
        $this->entity = $entity;
    }

    public function getTotalPedidoPorDia($date)
    {
        //return $this->entity->withSum('pedidos', 'comissao')->get();
    }

    public function getPedidosPorVendedor(int $idVendedor)
    {
        return $this->entity->where('id_vendedor', $idVendedor)->paginate();
    }
}
