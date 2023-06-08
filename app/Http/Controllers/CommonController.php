<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommonController extends Controller
{
    public function isHoliday($day) {
        //祝日json
        $holiday = Storage::get('holiday.json');
        return array_key_exists($day->copy()->format('Y-m-d'), json_decode($holiday, true));
    }
}
