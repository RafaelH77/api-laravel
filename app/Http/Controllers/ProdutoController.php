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
     *     path="/api/produto",
     *     @OA\Response(response="200", description="An example endpoint")
     * )
     */
    public function index()
    {
        return ProdutoResource::collection($this->service->getAll());
    }

    public function store(Request $request)
    {
        return new ProdutoResource($this->service->create($request->all()));
    }

    public function show($id)
    {
        return new ProdutoResource($this->service->getById($id));
    }

    public function update(Request $request, $id)
    {
        return $this->service->update($id, $request->all());
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
