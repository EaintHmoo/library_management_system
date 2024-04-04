<?php

namespace App\Helper;

use App\Models\Member;


class NoGenerator
{
    public static function generateMemberNo()
    {
        $counts = Member::where('member_no', 'like', 'MN%')->count() ?? 0;
        $subCount = Member::where('member_no', 'like', '%999999')->count() ?? 0;
        if ($counts >= 999999) {
            if ($subCount > 1) {
                $counts = 0;
            }
        }
        $member_no = 'MN' . sprintf("%03d", $subCount) . '-' . sprintf("%06d", $counts + 1);
        return $member_no;
    }
}
