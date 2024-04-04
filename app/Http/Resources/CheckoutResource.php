<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CheckoutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'issue_date' => $this->issue_date ? date('Y-m-d', strtotime($this->issue_date)) : null,
            'return_date' => $this->return_date ? date('Y-m-d', strtotime($this->return_date)) : null,
            'book_id' => $this->book_id,
            'book' => $this->book->title ?? '',
            'member_id' => $this->member_id,
            'member' => $this->member->member_no ?? '',
            'issued_by_id' => $this->issued_by_id,
            'issued_by' => $this->issued_by->name ?? '',
            'is_returned' => $this->is_returned,
            'is_overdate' => $this->is_overdate,
        ];
    }
}
