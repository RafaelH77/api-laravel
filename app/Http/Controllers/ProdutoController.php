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
        $list = $this->service->getAll();
        return ProdutoResource::collection($list);
    }

    public function store(ProdutoRequest $request)
    {
        $data = $this->service->create($request->all());
        return new ProdutoResource($data);
    }

    public function show($id)
    {
        $data = $this->service->getById($id);
        return new ProdutoResource($data);
    }

    public function update(ProdutoRequest $request, $id)
    {
        $data = $this->service->update($id, $request->all());
        return $data;
    }

    public function destroy($id)
    {
        $data = $this->service->delete($id);
        return $data;
    }
}
