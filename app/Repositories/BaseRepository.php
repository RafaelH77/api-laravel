<?php

namespace App\Repositories;

use App\Repositories\Interfaces\IRepository;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements IRepository
{
    protected $entity;

    public function __construct(Model $model)
    {
        $this->entity = $model;
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
        //return tap($this->entity->where('id', $id))->update($data)->first();
        return $this->entity->where('id', $id)->update($data);
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
