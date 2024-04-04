<?php

namespace App\Repository\Eloquent;

use Illuminate\Support\Str;
use App\Models\Publisher;
use App\Repository\PublisherReposityInterface;

class PublisherReposity implements PublisherReposityInterface
{
    protected $publisher;
    function __construct(Publisher $publisher)
    {
        $this->publisher = $publisher;
    }

    public function all()
    {
        return $this->publisher->all();
    }

    public function find($id)
    {
        return $this->publisher->findOrFail($id);
    }

    public function create(array $attributes)
    {
        return $this->publisher->create($attributes);
    }

    public function update(array $attributes, $id)
    {
        $publisher = $this->publisher->findOrFail($id);
        $publisher->update($attributes);
        return $publisher;
    }

    public function delete($id)
    {
        $publisher = $this->publisher->findOrFail($id);
        $publisher->delete();
    }
}
