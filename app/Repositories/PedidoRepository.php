<?php

namespace App\Repositories;

use App\Repositories\Interfaces\IPedidoRepository;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoRepository extends BaseRepository implements IPedidoRepository
{
    protected $entity;
    protected $queryFilters = ['vendedor_id'];

    public function __construct(Pedido $entity)
    {
        $this->entity = $entity;
    }

    public function getTotalPedidoPorDia($dataInicial, $dataFinal)
    {
        return $this->entity->whereBetween('pedidos.created_at', [$dataInicial, $dataFinal])->sum('pedidos.valor');
    }

}
