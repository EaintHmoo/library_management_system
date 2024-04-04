<?php

namespace App\Repository\Eloquent;

use App\Models\Book;
use App\Helper\FileUpload;
use Illuminate\Support\Str;
use App\Repository\BookReposityInterface;

class BookReposity implements BookReposityInterface
{
    protected $book;
    function __construct(Book $book)
    {
        $this->book = $book;
    }

    public function all($request)
    {
        $books = $this->book->newQuery();
        $title = $request['title'] ?? null;
        $book_category = $request['book_category'] ?? null;
        $author = $request['author'] ?? null;
        $publisher = $request['publisher'] ?? null;
        $books->when($title, function ($q) use ($title) {
            return $q->where('title', 'like', '%' . $title . '%');
        });
        $books->when($book_category, function ($q) use ($book_category) {
            return $q->whereRelation('book_category', 'name', 'like', '%' . $book_category . '%');
        });
        $books->when($author, function ($q) use ($author) {
            return $q->whereRelation('author', 'name', 'like', '%' . $author . '%');
        });
        $books->when($publisher, function ($q) use ($publisher) {
            return $q->whereRelation('publisher', 'name', 'like', '%' . $publisher . '%');
        });
        return $books->paginate(10);
    }

    public function find($id)
    {
        return $this->book->findOrFail($id);
    }

    public function create(array $attributes)
    {
        if ($attributes['image'] ?? '') {
            $image = FileUpload::upload('book', $attributes['image']);
        } else {
            $image = null;
        }

        return $this->book->create([
            'title' => $attributes['title'],
            'description' => $attributes['description'] ?? null,
            'isbn_no' => $attributes['isbn_no'],
            'status' => $attributes['status'] ?? 1,
            'copies_total' => $attributes['copies_total'] ?? 1,
            'copies_available' => $attributes['copies_available'] ?? 1,
            'edition' => $attributes['edition'] ?? null,
            'date_of_purchase' => $attributes['date_of_purchase'] ? date('Y-m-d', strtotime($attributes['date_of_purchase'])) : null,
            'price' => $attributes['price'] ?? 0,
            'image' => $image,
            'book_category_id' => $attributes['book_category_id'] ?? null,
            'author_id' => $attributes['author_id'] ?? null,
            'publisher_id' => $attributes['publisher_id'] ?? null,
            'location_id' => $attributes['location_id'] ?? null,
        ]);
    }

    public function update(array $attributes, $id)
    {
        $book = $this->book->findOrFail($id);

        if ($attributes['image'] ?? '') {
            if ($book->image) {
                FileUpload::delete($book->image);
            }
            $image = FileUpload::upload('book', $attributes['image']);
        } else {
            $image = $book->image;
        }

        $book->update(
            [
                'title' => $attributes['title'],
                'description' => $attributes['description'] ?? null,
                'isbn_no' => $attributes['isbn_no'],
                'status' => $attributes['status'] ?? $book->status,
                'copies_total' => $attributes['copies_total'] ?? 1,
                'copies_available' => $attributes['copies_available'] ?? 1,
                'edition' => $attributes['edition'] ?? null,
                'date_of_purchase' => $attributes['date_of_purchase'] ? date('Y-m-d', strtotime($attributes['date_of_purchase'])) : null,
                'price' => $attributes['price'] ?? 0,
                'image' => $image,
                'book_category_id' => $attributes['book_category_id'] ?? null,
                'author_id' => $attributes['author_id'] ?? null,
                'publisher_id' => $attributes['publisher_id'] ?? null,
                'location_id' => $attributes['location_id'] ?? null,
            ]
        );
        return $book;
    }

    public function updateCopyAvailable($status, $id)
    {
        $book = $this->book->findOrFail($id);
        $copy_available = $status === 'add' ? ($book->copies_available + 1) : ($book->copies_available - 1);
        $book->update([
            'copies_available' => $copy_available,
            'status' => $copy_available > 0,
        ]);
    }

    public function delete($id)
    {
        $book = $this->book->findOrFail($id);
        if ($book->image) {
            FileUpload::delete($book->image);
        }
        $book->delete();
    }
}
