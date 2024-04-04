<?php

namespace App\Repository\Eloquent;

use App\Models\Location;
use App\Repository\LocationReposityInterface;

class LocationReposity implements LocationReposityInterface
{
    protected $location;
    function __construct(Location $location)
    {
        $this->location = $location;
    }

    public function all()
    {
        return $this->location->all();
    }

    public function find($id)
    {
        return $this->location->findOrFail($id);
    }

    public function create(array $attributes)
    {
        return $this->location->create($attributes);
    }

    public function update(array $attributes, $id)
    {
        $location = $this->location->findOrFail($id);
        $location->update($attributes);
        return $location;
    }

    public function delete($id)
    {
        $location = $this->location->findOrFail($id);
        $location->delete();
    }
}
