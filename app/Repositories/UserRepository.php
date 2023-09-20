<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;

class UserRepository extends BaseRepository implements IUserRepository
{
    public function __construct(User $entity)
    {
        $this->entity = $entity;
    }

    public function getByEmail(string $email)
    {
        return $this->entity->where('email', $email)->first();
    }
}
