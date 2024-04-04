<?php

namespace App\Repository\Eloquent;

use App\Helper\LibraryHelper;
use App\Models\Checkout;
use App\Repository\BookReposityInterface;
use App\Repository\CheckoutReposityInterface;

class CheckoutReposity implements CheckoutReposityInterface
{
    protected $checkout;
    protected $bookRepo;
    function __construct(Checkout $checkout, BookReposityInterface $bookRepo)
    {
        $this->checkout = $checkout;
        $this->bookRepo = $bookRepo;
    }

    public function all($request)
    {
        $checkouts = $this->checkout->newQuery();
        $member = $request['member'] ?? null;
        $book = $request['book'] ?? null;
        $checkouts->when($member, function ($q) use ($member) {
            return $q->whereHas('member', function ($q) use ($member) {
                $q->where('member_no', $member)
                    ->orWhereRelation('user', 'name', 'like', '%' . $member . '%');
            });
        });

        $checkouts->when($book, function ($q) use ($book) {
            return $q->whereRelation('book', 'title', 'like', '%' . $book . '%');
        });

        return $checkouts->paginate(10);
    }

    public function find($id)
    {
        return $this->checkout->findOrFail($id);
    }

    public function create(array $attributes)
    {
        $this->bookRepo->updateCopyAvailable('sub', $attributes['book_id']);
        return $this->checkout->create([
            'issue_date' => isset($attributes['issue_date']) ? date('Y-m-d', strtotime($attributes['issue_date'])) : date('Y-m-d'),
            'return_date' => isset($attributes['return_date']) ? date('Y-m-d', strtotime($attributes['return_date'])) : null,
            'book_id' => $attributes['book_id'],
            'member_id' => $attributes['member_id'],
            'issued_by_id' => $attributes['issued_by_id'],
            'is_returned' => $attributes['is_returned'] ?? 0,
        ]);
    }

    public function update(array $attributes, $id)
    {
        $checkout = $this->checkout->findOrFail($id);
        $issue_date = $attributes['issue_date'] ? date('Y-m-d', strtotime($attributes['issue_date'])) : $checkout->issue_date;
        $return_date = $attributes['return_date'] ? date('Y-m-d', strtotime($attributes['return_date'])) : null;
        if ($attributes['is_returned'] != $checkout->is_returned) {
            if ($attributes['is_returned']) {
                $this->bookRepo->updateCopyAvailable('add', $attributes['book_id']);
            } else {
                $this->bookRepo->updateCopyAvailable('sub', $attributes['book_id']);
            }
        }
        $checkout->update(
            [
                'issue_date' => $issue_date,
                'return_date' => $return_date,
                'book_id' => $attributes['book_id'],
                'member_id' => $attributes['member_id'],
                'issued_by_id' => $attributes['issued_by_id'],
                'is_returned' => $attributes['is_returned'] ?? 0,
                'is_overdate' => $attributes['is_returned'] ? false : LibraryHelper::check_overdate($issue_date, $return_date),
            ]
        );

        return $checkout;
    }

    public function delete($id)
    {
        $checkout = $this->checkout->findOrFail($id);
        $checkout->delete();
    }
}
