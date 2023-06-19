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
     *  * @OA\Post(
     *     tags={"pedido"},
     *     path="/api/pedido",
     *    @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(
     *          required={"vendedor_id","valor", "itens"},
     *          @OA\Property(property="vendedor_id", type="bigint", example="1"),
     *          @OA\Property(property="valor", type="double", example="200"),
     *          @OA\Property(property="itens", type="array",
     *                @OA\Items(
     *                      @OA\Property(
     *                         property="produto_id",
     *                         type="bigint",
     *                         example="1"
     *                      ),
     *                      @OA\Property(
     *                         property="valor",
     *                         type="double",
     *                         example="50"
     *                      ),
     *                      @OA\Property(
     *                         property="quantidade",
     *                         type="double",
     *                         example="4"
     *                      ),
     *                ),
     *          ),
     *      ),
     *    ),
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
     *     @OA\Parameter(
     *          description="Id do pedido",
     *          name="id",
     *          in="path",
     *          @OA\Schema(type="bigint"),
     *          style="form",
     *     ),
     *     @OA\Response(response="200", description="Sucesso")
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
     *     @OA\Parameter(
     *          description="Id do pedido",
     *          name="id",
     *          in="path",
     *          @OA\Schema(type="bigint"),
     *          style="form",
     *     ),
     *    @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(
     *          required={"vendedor_id","valor", "itens"},
     *          @OA\Property(property="vendedor_id", type="bigint", example="1"),
     *          @OA\Property(property="valor", type="double", example="200"),
     *          @OA\Property(property="itens", type="array",
     *                @OA\Items(
     *                      @OA\Property(
     *                         property="produto_id",
     *                         type="bigint",
     *                         example="1"
     *                      ),
     *                      @OA\Property(
     *                         property="valor",
     *                         type="double",
     *                         example="50"
     *                      ),
     *                      @OA\Property(
     *                         property="quantidade",
     *                         type="double",
     *                         example="4"
     *                      ),
     *                ),
     *          ),
     *      ),
     *    ),
     *     @OA\Response(response="200", description="Sucesso")
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
     *     @OA\Parameter(
     *          description="Id do pedido",
     *          name="id",
     *          in="path",
     *          @OA\Schema(type="bigint"),
     *          style="form",
     *     ),
     *     @OA\Response(response="200", description="Sucesso")
     * )
     */
    public function destroy($id)
    {
        return $this->service->delete($id);
    }

    /**
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
     */
    public function totalPedidoDia(Request $request)
    {
        return new Response($this->service->getTotalPedidoPorDia($request->query('data')));
    }
}
