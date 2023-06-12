<?php

namespace App\Repositories;

use App\Repositories\Interfaces\IProdutoRepository;
use App\Models\Produto;

class ProdutoRepository extends BaseRepository implements IProdutoRepository
{
    protected $entity;

    public function __construct(Produto $entity)
    {
        $this->entity = $entity;
    }
}
