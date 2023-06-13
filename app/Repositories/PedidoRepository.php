<?php

namespace App\Repositories;

use App\Repositories\Interfaces\IPedidoRepository;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoRepository extends BaseRepository implements IPedidoRepository
{
    protected $entity;

    public function __construct(Pedido $entity)
    {
        $this->entity = $entity;
    }

    public function getAll(Request $request)
    {
        $query = $this->entity::query();

        if($request->has('vendedor_id')) {
            $query->where('vendedor_id', $request->query('vendedor_id'));
        }

        return $query->get();
    }

    public function getTotalPedidoPorDia($dataInicial, $dataFinal)
    {
        return $this->entity->whereBetween('pedidos.created_at', [$dataInicial, $dataFinal])->sum('pedidos.valor');
    }

}
