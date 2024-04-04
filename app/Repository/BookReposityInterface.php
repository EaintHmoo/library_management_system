<?php

namespace App\Repository;


interface BookReposityInterface
{
    public function all($request);
    public function find($id);
    public function create(array $attributes);
    public function update(array $attributes, $id);
    public function updateCopyAvailable($status, $id);
    public function delete($id);
}
