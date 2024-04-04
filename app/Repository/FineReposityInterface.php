<?php

namespace App\Repository;

interface FineReposityInterface
{
    public function all($request);
    public function find($id);
    public function create(array $attributes);
    public function update(array $attributes, $id);
    public function delete($id);
}
