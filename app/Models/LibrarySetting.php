<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LibrarySetting extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'library_settings';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'address',
        'contact_no',
        'book_return_day_limit',
        'late_return_one_day_fine',
        'book_issue_limit',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
