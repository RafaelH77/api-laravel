<?php

namespace App\Services;

use App\Repositories\Interfaces\IRepository;

class BaseService
{
    protected $repository;

    public function __construct(IRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return $array
     */
    public function getAll()
    {
        return $this->repository->getAll();
    }

    /**
     * @param int $id
     * @return object|null
     */
    public function getById(int $id): ?object
    {
        return $this->repository->getById($id);
    }

    /**
     * @param array $data
     * @return object $object
     */
    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return object $object
     */
    public function update(int $id, array $data)
    {
        $result = $this->repository->update($id, $data);
        return $result ? $this->getById($id) : response()->json(['message' => 'Not Found'], 404) ;
    }

    /**
     * @param int $id
     * @return object $object
     */
    public function delete(int $id)
    {
        $result = $this->repository->delete($id);
        return $result > 0 ? response()->json(['message' => 'Deleted']) : response()->json(['message' => 'Not Found'], 404) ;
    }
}
