<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
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
            'member_no' => $this->member_no,
            'date_of_membership' => $this->date_of_membership ? date('Y-m-d', strtotime($this->date_of_membership)) : null,
            'date_of_birth' => $this->date_of_birth ? date('Y-m-d', strtotime($this->date_of_birth)) : null,
            'address' => $this->address,
            'phone_no' => $this->phone_no,
            'user_id' => $this->user_id,
            'user' => $this->user->name,
        ];
    }
}
