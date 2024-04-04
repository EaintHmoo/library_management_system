<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checkout extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'checkouts';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'issue_date',
        'return_date',
        'book_id',
        'member_id',
        'issued_by_id',  //user_id
        'is_returned',
        'is_overdate',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function issued_by()
    {
        return $this->belongsTo(User::class, 'issued_by_id', 'id');
    }
}
