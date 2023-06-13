<?php

namespace App\Http\Controllers;

use App\Http\Resources\PedidoResource;
use App\Models\Pedido;
use App\Services\PedidoService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    protected $service;

    public function __construct(PedidoService $service)
    {
        $this->service = $service;
    }

    /**
     * Listar todos os pedidos
     *
     *  * @OA\Get(
     *     tags={"pedido"},
     *     path="/pedido",
     *     @OA\Response(response="200", description="Sucesso")
     *  )
     *
     */
    public function index(Request $request)
    {
        return PedidoResource::collection($this->service->getAll($request));
    }

    /**
     * Criar venda
     *
     *  * @OA\Post(
     *     tags={"pedido"},
     *     path="/pedido",
     *     @OA\Parameter(
     *          name="vendedor_id",
     *          in="query",
     *          @OA\Schema(type="bigint"),
     *          style="form",
     *     ),
     *     @OA\Parameter(
     *          name="valor",
     *          in="query",
     *          @OA\Schema(type="float"),
     *          style="form",
     *     ),
     *     @OA\Response(response="200", description="Sucesso")
     *  )
     *
     */
    public function store(Request $request)
    {
        return new PedidoResource($this->service->create($request));
    }

    /**
     * @OA\Get(
     *     tags={"pedido"},
     *     path="/api/pedido/{id}",
     *     @OA\Response(response="200", description="Mostrar Pedido")
     * )
     */
    public function show($id)
    {
        return new PedidoResource($this->service->getById($id));
    }

    /**
     * @OA\Put(
     *     tags={"pedido"},
     *     path="/api/pedido/{id}",
     *     @OA\Response(response="200", description="Atualizar Pedido")
     * )
     */
    public function update(Request $request, $id)
    {
        return $this->service->update($id, $request);
    }

    /**
     * @OA\Delete(
     *     tags={"pedido"},
     *     path="/api/pedido/{id}",
     *     @OA\Response(response="200", description="Excluir Pedido")
     * )
     */
    public function destroy($id)
    {
        return $this->service->delete($id);
    }

    /**
     * Mostrar o total de vendas do dia
     *
     *   * @OA\Get(
     *     tags={"pedido"},
     *     path="/pedido/total/{data}",
     *     @OA\Parameter(
     *          name="data",
     *          in="path",
     *          example="13-06-2022",
     *          @OA\Schema(type="string"),
     *          style="form",
     *     ),
     *     @OA\Response(response="200", description="Sucesso")
     *   )
     *
     * @param  string  $date
     * @return \Illuminate\Http\Response
     */
    public function showTotalOrders($date)
    {
        return new Response($this->service->getTotalPedidoPorDia($date));
        /*
        return new Response(
            DB::table('orders')
                ->select(DB::raw('SUM(orders.value) as total'))
                ->whereBetween('orders.created_at', [date("Y-m-d H:i:s", strtotime($date)), date("Y-m-d H:i:s", strtotime($date . ' 23:59:59'))])
                ->get(), 200
        );
        */
    }
}
