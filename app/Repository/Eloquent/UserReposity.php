<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Repository\UserReposityInterface;

class UserReposity implements UserReposityInterface
{
    protected $user;
    function __construct(User $user)
    {
        $this->user = $user;
    }

    public function all()
    {
        return $this->user->with(['roles'])->get();
    }

    public function find($id)
    {
        return $this->user->findOrFail($id)->load('roles');
    }

    public function create(array $attributes)
    {
        $user = $this->user->create([
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'password' => Hash::make($attributes['password']),
            'approved' => $attributes['approved'] ?? 0,
        ]);
        $user->roles()->sync($attributes['roles'] ?? []);

        return $user;
    }

    public function update(array $attributes, $id)
    {
        $user = $this->user->findOrFail($id);
        $user->update([
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'password' => isset($attributes['password']) ? Hash::make($attributes['password']) : $user->password,
            'approved' => $attributes['approved'] ?? 0,
        ]);
        $user->roles()->sync($attributes['roles'] ?? []);
        return $user;
    }

    public function delete($id)
    {
        $user = $this->user->findOrFail($id);
        $user->delete();
    }
}
