<?php

namespace App\Repositories;

use App\Repositories\Interfaces\IRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BaseRepository implements IRepository
{
    protected $entity;
    protected $queryFilters = [];

    /**
     * Lista todos
     * @return array
     */
    public function getAll()
    {
        $request = request();
        $query = $this->entity::query();

        foreach ($request->query() as $key => $value){
            if (in_array($key, $this->queryFilters)){
                $query->where($key, $value);
            }
        }

        return $query->get();
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
