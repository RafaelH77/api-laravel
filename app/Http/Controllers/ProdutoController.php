<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutoRequest;
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
     *     @OA\Response(response="200", description="Listar Produtos")
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
     *     @OA\Response(response="200", description="Criar Produto")
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
     *     @OA\Response(response="200", description="Mostrar Produto")
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
     *     @OA\Response(response="200", description="Atualizar Produto")
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
     *     @OA\Response(response="200", description="Excluir Produto")
     * )
     */
    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
