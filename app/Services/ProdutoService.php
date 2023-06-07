<?php


namespace App\Services;


use App\Repositories\Interfaces\IProdutoRepository;

class ProdutoService
{
    protected $repository;

    public function __construct(IProdutoRepository $repository)
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
        $object = $this->repository->getById($id);

        if (!$object) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $this->repository->update($id, $data);
        return response()->json(['message' => 'Updated'], 200);
    }

    /**
     * @param int $id
     * @return object $object
     */
    public function delete(int $id)
    {
        $object = $this->repository->getById($id);

        if (!$object) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $this->repository->delete($object);
        return response()->json(['message' => 'Deleted'], 200);
    }
}
