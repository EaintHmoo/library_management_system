<?php

namespace App\Repository;


interface LibrarySettingReposityInterface
{
    public function all();
    public function find($id);
    public function create(array $attributes);
    public function update(array $attributes, $id);
    public function delete($id);
}
