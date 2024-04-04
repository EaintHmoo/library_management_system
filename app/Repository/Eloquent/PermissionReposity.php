<?php

namespace App\Repository\Eloquent;

use App\Models\Permission;
use App\Repository\PermissionReposityInterface;

class PermissionReposity implements PermissionReposityInterface
{
    protected $permission;
    function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    public function all()
    {
        return $this->permission->all();
    }

    public function find($id)
    {
        return $this->permission->findOrFail($id);
    }

    public function create(array $attributes)
    {
        return $this->permission->create($attributes);
    }

    public function update(array $attributes, $id)
    {
        $permission = $this->permission->findOrFail($id);
        $permission->update($attributes);
        return $permission;
    }

    public function delete($id)
    {
        $permission = $this->permission->findOrFail($id);
        $permission->delete();
    }
}
