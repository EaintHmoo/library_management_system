<?php

namespace App\Helper;

use App\Models\LibrarySetting;
use App\Models\Member;


class LibraryHelper
{
    public static function check_overdate($issue_date, $return_date)
    {
        $limit = LibrarySetting::first()->book_return_day_limit;
        $today = $return_date ? date('d-m-Y', strtotime($return_date)) : date('Y-m-d');
        $issue_date = date('d-m-Y', strtotime($issue_date));
        $diff =  date_diff(date_create($issue_date), date_create($today));
        return $diff->format("%R%a") > $limit;
    }
}
