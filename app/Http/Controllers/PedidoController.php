<?php

namespace App\Http\Controllers;

use App\Http\Resources\PedidoResource;
use App\Services\PedidoService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PedidoController extends Controller
{
    protected $service;

    public function __construct(PedidoService $service)
    {
        $this->service = $service;
    }

    /**
     *  * @OA\Get(
     *     tags={"pedido"},
     *     path="/api/pedido",
     *     @OA\Response(response="200", description="Sucesso")
     *  )
     *
     */
    public function index()
    {
        return PedidoResource::collection($this->service->getAll());
    }

    /**
     * Criar venda
     *
     *  * @OA\Post(
     *     tags={"pedido"},
     *     path="/api/pedido",
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
        return new PedidoResource($this->service->create($request->all()));
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
        return $this->service->update($id, $request->all());
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
     *     path="/api/pedidos/totalDia",
     *     @OA\Parameter(
     *          name="data",
     *          in="query",
     *          example="13-06-2023",
     *          @OA\Schema(type="string"),
     *          style="form",
     *     ),
     *     @OA\Response(response="200", description="Sucesso")
     *   )
     *
     */
    public function totalPedidoDia(Request $request)
    {
        return new Response($this->service->getTotalPedidoPorDia($request->query('data')));
    }
}
