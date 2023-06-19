<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProdutoResource;
use App\Services\ProdutoService;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    protected $service;

    public function __construct(ProdutoService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     tags={"produto"},
     *     path="/api/produto",
     *     @OA\Response(response="200", description="Sucesso")
     * )
     */
    public function index()
    {
        return ProdutoResource::collection($this->service->getAll());
    }

    /**
     * @OA\Post(
     *     tags={"produto"},
     *     path="/api/produto",
     *    @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(
     *          required={"nome","descricao", "estoque", "preco"},
     *          @OA\Property(property="nome", type="string", example="Caneta azul"),
     *          @OA\Property(property="descricao", type="string", example="Caneta azul ponta fina"),
     *          @OA\Property(property="estoque", type="double", example="100"),
     *          @OA\Property(property="preco", type="double", example="5"),
     *      ),
     *    ),
     *     @OA\Response(response="200", description="Sucesso")
     * )
     */
    public function store(Request $request)
    {
        return new ProdutoResource($this->service->create($request->all()));
    }

    /**
     * @OA\Get(
     *     tags={"produto"},
     *     path="/api/produto/{id}",
     *     @OA\Parameter(
     *          description="Id do produto",
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
        return new ProdutoResource($this->service->getById($id));
    }

    /**
     * @OA\Put(
     *     tags={"produto"},
     *     path="/api/produto/{id}",
     *     @OA\Parameter(
     *          description="Id do produto",
     *          name="id",
     *          in="path",
     *          @OA\Schema(type="bigint"),
     *          style="form",
     *     ),
     *    @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(
     *          required={"nome","descricao", "estoque", "preco"},
     *          @OA\Property(property="nome", type="string", example="Caneta azul"),
     *          @OA\Property(property="descricao", type="string", example="Caneta azul ponta fina"),
     *          @OA\Property(property="estoque", type="double", example="100"),
     *          @OA\Property(property="preco", type="double", example="5"),
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
     *     tags={"produto"},
     *     path="/api/produto/{id}",
     *     @OA\Parameter(
     *          description="Id do produto",
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
}
