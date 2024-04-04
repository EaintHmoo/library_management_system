<?php

namespace App\Repository\Eloquent;

use App\Models\Role;
use App\Repository\RoleReposityInterface;

class RoleReposity implements RoleReposityInterface
{
    protected $role;
    function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function all()
    {
        return $this->role->with(['permissions'])->get();
    }

    public function find($id)
    {
        return $this->role->findOrFail($id)->load('permissions');
    }

    public function create(array $attributes)
    {
        $role = $this->role->create($attributes);
        $role->permissions()->sync($attributes['permissions'] ?? []);
        return $role;
    }

    public function update(array $attributes, $id)
    {
        $role = $this->role->findOrFail($id);
        $role->update($attributes);
        $role->permissions()->sync($attributes['permissions'] ?? []);
        return $role;
    }

    public function delete($id)
    {
        $role = $this->role->findOrFail($id);
        $role->delete();
    }
}
