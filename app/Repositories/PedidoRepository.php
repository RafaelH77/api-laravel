<?php

namespace App\Repositories;

use App\Repositories\Interfaces\IPedidoRepository;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoRepository extends BaseRepository implements IPedidoRepository
{
    protected $queryFilters = ['vendedor_id'];

    public function __construct(Pedido $entity)
    {
        $this->entity = $entity;
    }

    public function getByIdWithVendedor(int $id)
    {
        return $this->entity::with('vendedor')->where('id', $id)->first();
    }

    public function getTotalPedidoPorDia($dataInicial, $dataFinal)
    {
        return $this->entity->whereBetween('pedidos.created_at', [$dataInicial, $dataFinal])->sum('pedidos.valor');
    }

}
