<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'books';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'description',
        'isbn_no',
        'status',
        'copies_total',
        'copies_available',
        'edition',
        'date_of_purchase',
        'price',
        'image',
        'book_category_id',
        'author_id',
        'publisher_id',
        'location_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function book_category()
    {
        return $this->belongsTo(BookCategory::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
