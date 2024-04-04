<?php

namespace App\Repository\Eloquent;

use App\Helper\NoGenerator;
use Illuminate\Support\Str;
use App\Models\Member;
use App\Repository\MemberReposityInterface;

class MemberReposity implements MemberReposityInterface
{
    protected $member;
    function __construct(Member $member)
    {
        $this->member = $member;
    }

    public function all()
    {
        return $this->member->all();
    }

    public function find($id)
    {
        return $this->member->findOrFail($id);
    }

    public function create(array $attributes)
    {
        return $this->member->create([
            'member_no' => NoGenerator::generateMemberNo(),
            'date_of_membership' => $attributes['date_of_membership'] ? date('Y-m-d', strtotime($attributes['date_of_membership'])) : null,
            'date_of_birth' => $attributes['date_of_birth'] ? date('Y-m-d', strtotime($attributes['date_of_birth'])) : null,
            'address' => $attributes['address'],
            'phone_no' => $attributes['phone_no'],
            'user_id' => $attributes['user_id'],
        ]);
    }

    public function update(array $attributes, $id)
    {
        $member = $this->member->findOrFail($id);
        $member->update(
            [
                'member_no' => $attributes['member_no'] ?? $member->member_no,
                'date_of_membership' => $attributes['date_of_membership'] ? date('Y-m-d', strtotime($attributes['date_of_membership'])) : null,
                'date_of_birth' => $attributes['date_of_birth'] ? date('Y-m-d', strtotime($attributes['date_of_birth'])) : null,
                'address' => $attributes['address'],
                'phone_no' => $attributes['phone_no'],
                'user_id' => $attributes['user_id'],
            ]
        );
        return $member;
    }

    public function delete($id)
    {
        $member = $this->member->findOrFail($id);
        $member->delete();
    }
}
