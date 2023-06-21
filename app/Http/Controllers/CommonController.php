<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Staff;
use App\Models\Unit;
use App\Models\Reserve;
use App\Models\Manage\BasicInformation;

use Carbon\Carbon;

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

    //医院の休診情報と該当日付から、休診か診療かを判定
    public function is_closed($day, $closed)
    {
        //曜日番号を取得
        $dow = $day->dayOfWeekIso;
        //該当月で何週目か取得
        $number_of_week = $day->weekNumberInMonth;
        //曜日番号を曜日に紐づける配列取得
        $number_to_week = config('app.number_to_week');
        //休診情報から、該当日が休診か判定
        $is_closed = $closed[$number_of_week - 1][$number_to_week[$dow - 1]]['is_closed'];
        return $is_closed;
    }

    //該当医院にスタッフ登録があるか判定
    public function staff_exists($manage_id)
    {
        $staff_count = Staff::where('manage_id', $manage_id)->count();
        return $staff_count > 0;
    }
    //該当医院にユニット登録があるか判定
    public function unit_exists($manage_id)
    {
        $unit_count = Unit::where('manage_id', $manage_id)->count();
        return $unit_count > 0;
    }

    //医院休診情報と日付から該当日の時間別予約閾値を算出
    public function __threshold($common, $day, $closed, $manage_id)
    {
        //該当医院が該当日に診療か休診か取得
        $is_closed = $common->is_closed($day, $closed);
        if ($is_closed) return 0;
        //スタッフ登録がない場合は閾値0をreturn
        $staff_exists = $common->staff_exists($manage_id);
        if (!$staff_exists) return 0;
        //ユニット登録がない場合は閾値0をreturn
        $unit_exists = $common->unit_exists($manage_id);
        if (!$unit_exists) return 0;
        $day_of_threshold = $common->day_of_threshold($manage_id, $day);
        return $day_of_threshold;
    }

    //医院IDと日付からその日の閾値を算出
    public function day_of_threshold($manage_id, $day)
    {
        $basic = BasicInformation::where('manage_id', $manage_id)->first();
        $start_time = $basic['business_start'];
        $end_time = $basic['business_end'];
        if (!$start_time || !$end_time) return 0;
        $staffs = Staff::where('manage_id', $manage_id)->withWhereHas('shifts', function ($query) use ($day) {
            $query->where('date', $day->format('Y-m-d'));
        })->get();
        if (!$staffs) return 0;
        $units = Unit::where('manage_id', $manage_id)->where('status', 'S')->get();
        if (!$units) return 0;
        $start_time = new Carbon('1970-01-01 ' . $basic['business_start']);
        $end_time = new Carbon('1970-01-01 ' . $basic['business_end']);
        //全体閾値
        $threshold_list = [];
        //スタッフ閾値
        $threshold_list_staff = [];
        //ユニット閾値
        $threshold_list_unit = [];
        //各閾値30分単位初期化
        while ($start_time < $end_time) {
            $threshold_list[$start_time->copy()->format('H:i')] = 0;
            $threshold_list_staff[$start_time->copy()->format('H:i')] = 0;
            $threshold_list_unit[$start_time->copy()->format('H:i')] = 0;
            $start_time->addMinutes(30);
        }
        //診療開始終了時間
        $business_start = new Carbon($basic['business_start']);
        $business_end = new Carbon($basic['business_end']);
        foreach (json_decode($staffs, true) as $staff) {
            $shift_start = new Carbon($staff['shifts'][0]['start_time']);
            $shift_end = new Carbon($staff['shifts'][0]['end_time']);
            //予約受付の開始時間(シフト開始が診療開始以降の場合は予約受付開始時間はシフトの開始時間で上書き)
            $reserve_start = $business_start > $shift_start ? $business_start->copy() : $shift_start;
            //予約受付の終了時間(シフト終了が診療終了以前の場合は予約受付終了時間はシフトの終了時間で上書き)
            $reserve_end = $business_end > $shift_end ? $shift_end : $business_end->copy();
            //該当スタッフの該当日の予約取得
            $reserves = Reserve::where('manage_id', $manage_id)->where('staff_id', $staff['id'])->where('reserve_date', $day->format('Y-m-d'))->get();
            while ($reserve_start < $reserve_end) {
                //枠の開始終了時間
                $frame_start = $reserve_start->copy()->format('H:i');
                $frame_end = $reserve_start->copy()->addMinutes(30)->format('H:i');
                //既予約フラグ
                $is_exist = 0;
                foreach ($reserves as $reserve) {
                    $reserve_start_time = new Carbon($reserve['start_time']);
                    $reserve_end_time = new Carbon($reserve['end_time']);
                    //該当の枠にすでに予約がある場合は既予約フラグを立てる
                    if (!($reserve_end_time->format('H:i') <= $frame_start || $frame_end <= $reserve_start_time->format('H:i'))) $is_exist = 1;
                }
                //既予約フラグが立っていない場合は枠の閾値を+1
                if (!$is_exist) $threshold_list_staff[$frame_start]++;
                $reserve_start->addMinutes(30);
            }
        }
        foreach (json_decode($units, true) as $unit) {
            //予約受付の開始終了時間
            $reserve_start = $business_start->copy();
            $reserve_end = $business_end->copy();
            //該当スタッフの該当日の予約取得
            $reserves = Reserve::where('manage_id', $manage_id)->where('unit_id', $unit['id'])->where('reserve_date', $day->format('Y-m-d'))->get();
            while ($reserve_start < $reserve_end) {
                //枠の開始終了時間
                $frame_start = $reserve_start->copy()->format('H:i');
                $frame_end = $reserve_start->copy()->addMinutes(30)->format('H:i');
                //既予約フラグ
                $is_exist = 0;
                foreach ($reserves as $reserve) {
                    $reserve_start_time = new Carbon($reserve['start_time']);
                    $reserve_end_time = new Carbon($reserve['end_time']);
                    //該当の枠にすでに予約がある場合は既予約フラグを立てる
                    if (!($reserve_end_time->format('H:i') <= $frame_start || $frame_end <= $reserve_start_time->format('H:i'))) $is_exist = 1;
                }
                //既予約フラグが立っていない場合は枠の閾値を+1
                if (!$is_exist) $threshold_list_unit[$frame_start]++;
                $reserve_start->addMinutes(30);
            }
        }
        foreach ($threshold_list as $key => $child) {
            $threshold_list[$key] = $threshold_list_staff[$key] > $threshold_list_unit[$key] ? $threshold_list_unit[$key] : $threshold_list_staff[$key];
        }
        return $threshold_list;
    }
}
