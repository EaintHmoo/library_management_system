<?php

namespace App\Repository\Eloquent;

use App\Models\Author;
use App\Repository\AuthorRepositoryInterface;

class AuthorReposity implements AuthorRepositoryInterface
{
    protected $author;
    function __construct(Author $author)
    {
        $this->author = $author;
    }

    public function all()
    {
        return $this->author->all();
    }

    public function find($id)
    {
        return $this->author->with('books')->findOrFail($id);
    }

    public function create(array $attributes)
    {
        return $this->author->create($attributes);
    }

    public function update(array $attributes, $id)
    {
        $author = $this->author->findOrFail($id);
        $author->update($attributes);
        return $author;
    }

    public function delete($id)
    {
        $author = $this->author->findOrFail($id);
        $author->delete();
    }
}
