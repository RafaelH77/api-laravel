<?php

namespace App\Services;

use App\Repositories\Interfaces\IRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
        return $result ? $this->getById($id) : response()->json(['message' => 'Not Found'], 404);
    }

    /**
     * @param int $id
     * @return object $object
     */
    public function delete(int $id)
    {
        $result = $this->repository->delete($id);
        return $result > 0 ? response()->json(['message' => 'Deleted']) : response()->json(['message' => 'Not Found'], 404);
    }

    public function validate($rules)
    {
        try {
            request()->validate($rules);
        } catch (ValidationException $exception) {
            response()->json(['errors' => $exception->errors()], 400)->send();
            die();
        }
    }

    protected function UpdateOrDeleteChildren($entity, $relation, $dbChildList, $childList)
    {
        if (is_null($childList))
            return;

        $childListIds = array_column($childList, 'id');

        // Delete children
        if (!is_null($dbChildList) && $dbChildList->exists()) {
            $childListIdsDelete = array_column(array_filter($dbChildList->get()->toArray(), function ($value) use ($childListIds) {
                return !in_array($value['id'], $childListIds);
            }), 'id');

            $entity->getRelation($relation)->toQuery()->whereIn('id', $childListIdsDelete)->delete();
        }

        // Update/Insert children
        foreach ($childList as $child) {
            $existingChild = null;
            if (array_key_exists('id', $child))
                $existingChild = $entity->getRelation($relation)->toQuery()->where('id', '=', $child['id']);

            if (!is_null($existingChild)) {
                $existingChild->update($child);
            } else {
                $dbChildList->create($child);
            }
        }
    }
}
