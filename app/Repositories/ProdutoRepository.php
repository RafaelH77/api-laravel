<?php


namespace App\Repositories;


use App\Repositories\Interfaces\IProdutoRepository;
use App\Models\Produto;


class ProdutoRepository implements IProdutoRepository
{
    protected $entity;

    public function __construct(Produto $produto)
    {
        $this->entity = $produto;
    }

    /**
     * Lista todos
     * @return array
     */
    public function getAll()
    {
        return $this->entity->paginate();
    }

    /**
     * Seleciona por ID
     * @param int $id
     * @return object
     */
    public function getById(int $id)
    {
        return $this->entity->where('id', $id)->first();
    }

    /**
     * Cria
     * @param array $data
     * @return object
     */
    public function create(array $data)
    {
        return $this->entity->create($data);
    }

    /**
     * Atualiza
     * @param int $id
     * @param array $data
     * @return object
     */
    public function update(int $id, array $data)
    {
        return $this->entity->update($id, $data);
    }

    /**
     * Deleta
     * @param int $id
     * @return int
     */
    public function delete(int $id)
    {
        return $this->entity->where('id', $id)->delete();
    }
}
