<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'authors';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'nationality',
        'year_of_birth',
        'year_of_death',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
