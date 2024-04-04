<?php

namespace App\Repository\Eloquent;

use Illuminate\Support\Str;
use App\Models\BookCategory;
use App\Repository\BookCategoryReposityInterface;

class BookCategoryReposity implements BookCategoryReposityInterface
{
    protected $book_category;
    function __construct(BookCategory $book_category)
    {
        $this->book_category = $book_category;
    }

    public function all()
    {
        return $this->book_category->all();
    }

    public function find($id)
    {
        return $this->book_category->findOrFail($id);
    }

    public function create(array $attributes)
    {
        return $this->book_category->create([
            'name' => $attributes['name'],
            'slug' => Str::slug($attributes['name'], "-"),
        ]);
    }

    public function update(array $attributes, $id)
    {
        $book_category = $this->book_category->findOrFail($id);
        $book_category->update(
            [
                'name' => $attributes['name'],
                'slug' => Str::slug($attributes['name'], "-"),
            ]
        );
        return $book_category;
    }

    public function delete($id)
    {
        $book_category = $this->book_category->findOrFail($id);
        $book_category->delete();
    }
}
