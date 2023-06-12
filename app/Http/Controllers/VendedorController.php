<?php

namespace App\Http\Controllers;

use App\Http\Resources\VendedorResource;
use App\Services\VendedorService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class VendedorController extends Controller
{
    protected $service;

    public function __construct(VendedorService $service)
    {
        $this->service = $service;
    }

    /**
     * Listar todos os vendedores
     *
     *  * @OA\Get(
     *     tags={"vendedor"},
     *     path="/vendedor",
     *     @OA\Response(response="200", description="Sucesso")
     *  )
     *
     */
    public function index()
    {
        return VendedorResource::collection($this->service->getAll());
    }

    /**
     *
     *  * @OA\Post(
     *     tags={"vendedor"},
     *     path="/vendedor",
     *     @OA\Parameter(
     *          name="nome",
     *          in="query",
     *          @OA\Schema(type="string"),
     *          style="form",
     *     ),
     *     @OA\Parameter(
     *          name="email",
     *          in="query",
     *          @OA\Schema(type="string"),
     *          style="form",
     *     ),
     *     @OA\Response(response="200", description="Sucesso")
     *  )
     *
     */
    public function store(Request $request)
    {
        return new VendedorResource($this->service->create($request->all()));
    }

    /**
     * @OA\Get(
     *     tags={"vendedor"},
     *     path="/api/vendedor/{id}",
     *     @OA\Response(response="200", description="Mostrar Vendedor")
     * )
     */
    public function show($id)
    {
        return new VendedorResource($this->service->getById($id));
    }

    /**
     * @OA\Put(
     *     tags={"vendedor"},
     *     path="/api/vendedor/{id}",
     *     @OA\Response(response="200", description="Atualizar Vendedor")
     * )
     */
    public function update(Request $request, $id)
    {
        return $this->service->update($id, $request->all());
    }

    /**
     * @OA\Delete(
     *     tags={"vendedor"},
     *     path="/api/vendedor/{id}",
     *     @OA\Response(response="200", description="Excluir Vendedor")
     * )
     */
    public function destroy($id)
    {
        return $this->service->delete($id);
    }

    /**
     * Listar todos os vendedores
     *
     *  * @OA\Get(
     *     tags={"vendedor"},
     *     path="/vendedor/{vendedor}/listarPedidos",
     *     @OA\Response(response="200", description="Sucesso")
     *  )
     *
     */
    public function listarPedidos($id)
    {
        return new Response($this->service->getPedidosById($id));
    }

    /**
     * Mostrar todas as vendas do vendedor
     *
     *   * @OA\Get(
     *     tags={"vendedor"},
     *     path="/vendedor/{vendedor}/pedido",
     *     @OA\Parameter(
     *          name="vendedor",
     *          in="path",
     *          @OA\Schema(type="bigint"),
     *          style="form",
     *     ),
     *     @OA\Response(response="200", description="Sucesso")
     *   )
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showOrders($id)
    {
        return new Response(
            DB::table('vendedores')
                ->join('pedidos', 'vendedores.id', '=', 'pedidos.vendedor_id')
                ->select('pedidos.id', 'vendedores.nome', 'vendedores.email', DB::raw('ROUND(pedidos.comissao, 2) as comissao'),
                    'pedidos.valor', 'pedidos.created_at')
                ->where('vendedores.id', '=', $id)
                ->get(), 200
        );
    }

}
