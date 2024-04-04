<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\URL;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->image ? URL::to('/storage/' . $this->image) : null,
            'isbn_no' => $this->isbn_no,
            'status' => $this->status,
            'copies_total' => $this->copies_total,
            'copies_available' => $this->copies_available,
            'edition' => $this->edition,
            'date_of_purchase' => $this->date_of_purchase ? date('d-m-Y', strtotime($this->date_of_purchase)) : null,
            'price' => $this->price,
            'book_category_id' => $this->book_category_id,
            'book_category' => $this->book_category->name,
            'author_id' => $this->author_id,
            'author' => $this->author->name,
            'publisher_id' => $this->publisher_id,
            'publisher' => $this->publisher->name,
            'location' => $this->location,
            'created_at' => $this->created_at,
        ];
    }
}
