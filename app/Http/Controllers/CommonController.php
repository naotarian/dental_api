<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommonController extends Controller
{
    public function isHoliday($day)
    {
        //祝日json
        $holiday = Storage::get('holiday.json');
        return array_key_exists($day->copy()->format('Y-m-d'), json_decode($holiday, true));
    }


    //診療時間内で、予約可能な時間帯を配列で返す
    public function is_reserve_day_list($start, $end)
    {
        $tStart = strtotime($start);
        $tEnd = strtotime($end);
        $tNow = $tStart;
        $date_list = [];
        $i = 0;
        while ($tNow < $tEnd) {
            if ($i === 0) array_push($date_list, date("H:i", $tNow));
            $tNow = strtotime('+30 minutes', $tNow);
            array_push($date_list, date("H:i", $tNow));
            $i++;
        }
        if (count($date_list) > 0) array_pop($date_list);
        return $date_list;
    }
}
