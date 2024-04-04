<?php

namespace App\Repository\Eloquent;

use Illuminate\Support\Str;
use App\Models\Fine;
use App\Repository\FineReposityInterface;

class FineReposity implements FineReposityInterface
{
    protected $fine;
    function __construct(Fine $fine)
    {
        $this->fine = $fine;
    }

    public function all($request)
    {
        $fines = $this->fine->newQuery();
        $member = $request['search'] ?? null;
        $fines->when($member, function ($q) use ($member) {
            return $q->whereHas('member', function ($q) use ($member) {
                $q->where('member_no', $member)
                    ->orWhereRelation('user', 'name', 'like', '%' . $member . '%');
            });
        });

        return $fines->get();
    }

    public function find($id)
    {
        return $this->fine->findOrFail($id);
    }

    public function create(array $attributes)
    {
        return $this->fine->create([
            'fine_amount' => $attributes['fine_amount'],
            'is_checked' => $attributes['is_checked'] ?? 0,
            'member_id' => $attributes['member_id'],
            'checkout_id' => $attributes['checkout_id'],
            'fine_date' => $attributes['fine_date'] ? date('Y-m-d', strtotime($attributes['fine_date'])) : date('Y-m-d'),
            'payment_date' => $attributes['payment_date'] ? date('Y-m-d', strtotime($attributes['payment_date'])) : null,
        ]);
    }

    public function update(array $attributes, $id)
    {
        $fine = $this->fine->findOrFail($id);
        $fine->update(
            [
                'fine_amount' => $attributes['fine_amount'],
                'is_checked' => $attributes['is_checked'] ?? 0,
                'member_id' => $attributes['member_id'],
                'checkout_id' => $attributes['checkout_id'],
                'fine_date' => $attributes['fine_date'] ? date('Y-m-d', strtotime($attributes['fine_date'])) : $fine->fine_date,
                'payment_date' => $attributes['payment_date'] ? date('Y-m-d', strtotime($attributes['payment_date'])) : null,
            ]
        );
        return $fine;
    }

    public function delete($id)
    {
        $fine = $this->fine->findOrFail($id);
        $fine->delete();
    }
}
