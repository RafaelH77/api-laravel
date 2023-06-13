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
     *     path="/vendedor/pedidos/comissao",
     *     @OA\Response(response="200", description="Sucesso")
     *  )
     *
     */
    public function listarVendedoresComissao()
    {
        return VendedorResource::collection($this->service->getVendedoresComissao());
    }

    /**
     * Mostrar todas as vendas do vendedor
     *
     *   * @OA\Get(
     *     tags={"vendedor"},
     *     path="/vendedor/{vendedor}/pedidos",
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
    public function listarPedidos($id)
    {
        return new Response($this->service->getPedidosById($id));
    }

}
