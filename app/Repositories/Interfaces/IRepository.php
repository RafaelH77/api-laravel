<?php


namespace App\Repositories\Interfaces;


use Illuminate\Http\Request;

interface IRepository
{
    public function getAll(Request $request);
    public function getById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
