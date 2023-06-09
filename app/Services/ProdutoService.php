<?php

namespace App\Services;

use App\Repositories\Interfaces\IProdutoRepository;

class ProdutoService extends BaseService
{
    protected $repository;

    public function __construct(IProdutoRepository $repository)
    {
        $this->repository = $repository;
    }
}
