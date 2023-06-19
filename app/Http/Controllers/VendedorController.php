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
     *  * @OA\Get(
     *     tags={"vendedor"},
     *     path="/api/vendedor",
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
     *     path="/api/vendedor",
     *    @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(
     *          required={"nome","email"},
     *          @OA\Property(property="nome", type="string", example="João"),
     *          @OA\Property(property="email", type="string", format="email", example="joao@hotmail.com"),
     *      ),
     *    ),
     *    @OA\Response(response="200", description="Sucesso")
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
     *     @OA\Parameter(
     *          description="Id do vendedor",
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
        return new VendedorResource($this->service->getById($id));
    }

    /**
     * @OA\Put(
     *     tags={"vendedor"},
     *     path="/api/vendedor/{id}",
     *     @OA\Parameter(
     *          description="Id do vendedor",
     *          name="id",
     *          in="path",
     *          @OA\Schema(type="bigint"),
     *          style="form",
     *     ),
     *    @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(
     *          required={"email","password"},
     *          @OA\Property(property="nome", type="string", example="João"),
     *          @OA\Property(property="email", type="string", format="email", example="joao@hotmail.com"),
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
     *     tags={"vendedor"},
     *     path="/api/vendedor/{id}",
     *     @OA\Parameter(
     *          description="Id do vendedor",
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
     * Listar todos os vendedores
     *
     *  * @OA\Get(
     *     tags={"vendedor"},
     *     path="/api/vendedor/pedidos/comissao",
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
     *     path="/api/vendedor/{id}/pedidos",
     *     @OA\Parameter(
     *          description="Id do vendedor",
     *          name="id",
     *          in="path",
     *          @OA\Schema(type="bigint"),
     *          style="form",
     *     ),
     *     @OA\Response(response="200", description="Sucesso")
     *   )
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function listarPedidos($id)
    {
        return new Response($this->service->getPedidosById($id));
    }

}
