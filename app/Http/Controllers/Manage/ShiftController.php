<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Manage;
use App\Models\Shift;
use App\Models\Manage\BasicInformation;
use Illuminate\Support\Facades\Auth;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ShiftController extends Controller
{
    public function fetch($date = null)
    {
        $content = $this->initial($date);
        return response()->json($content);
    }

    public function update(Request $request)
    {
        $date = $request['date'];
        $shifts = $request['shifts'];
        foreach ($shifts as $date => $shift) {
            foreach ($shift as $s) {
                $target = Shift::where('staff_id', $s['staff_id'])->where('date', $s['date'])->first();
                if (!$target) {
                    $target = new Shift();
                    $target->staff_id = $s['staff_id'];
                    $target->date = $s['date'];
                }
                $target->start_time = $s['start_time'];
                $target->end_time = $s['end_time'];
                if ($target->isDirty()) $target->save();
            }
        }
        $content = $this->initial($date);
        return response()->json($content);
    }

    public function delete(Request $request) {
        $targets = $request['data'];
        foreach($targets as $target) {
            $data = Shift::where('staff_id', $target['id'])->where('date', $target['day'])->first();
            if($data) $data->delete();
        }
        $content = $this->initial($request['date']);
        return response()->json($content);
    }

    public function initial($date = null)
    {
        $manage_id = Auth::id();
        $staff = Staff::where('manage_id', $manage_id)->get();
        $holiday = Storage::get('holiday.json');
        //当月の開始日と終了日を生成
        if ($date) {
            $tmp_date = new Carbon($date);
            $start_of_month = $tmp_date->startOfMonth()->toDateString();
            $end_of_month = $tmp_date->endOfMonth()->toDateString();
        } else {
            $start_of_month = Carbon::now()->startOfMonth()->toDateString();
            $end_of_month = Carbon::now()->endOfMonth()->toDateString();
        }
        $target_days = CarbonPeriod::create($start_of_month, $end_of_month)->toArray();
        $target_list = [];
        foreach ($target_days as $day) {
            $is_closed = $this->is_closed($day);
            $target_list[$day->copy()->format('Y-m-d')] = [
                'day' => $day->copy()->format('n月j日'),
                'dow' => $day->copy()->format('N'),
                'day_format' => $day->copy()->format('Y-m-d'),
                'holiday' => array_key_exists($day->copy()->format('Y-m-d'), json_decode($holiday, true)),
                'closed' => $is_closed
            ];
        }
        $date = new Carbon($start_of_month);
        $target_month = $date->copy()->month;
        $target_year = $date->copy()->year;
        $staff_ids = [];
        $staffs = Manage::where('id', $manage_id)->with('staff')->first();
        if ($staffs['staff']) {
            foreach ($staffs['staff'] as $data) {
                array_push($staff_ids, $data['id']);
            }
        }
        $shifts = [];
        foreach ($target_list as $key => $d) {
            $shifts[$key] = Shift::where('date', $key)->whereIn('staff_id', $staff_ids)->get()->toArray();
        }
        $content = ['staff' => $staff, 'days' => $target_list, 'target_year' => $target_year, 'target_month' => $target_month, 'shifts' => $shifts];
        return $content;
    }

    //該当日が休診日か否か判定する
    public function is_closed($day) {
        $manage_id = Auth::id();
        $holiday = Storage::get('holiday.json');
        //休診情報取得
        $basic_information = BasicInformation::where('manage_id', $manage_id)->first();
        $closed = $basic_information['closed'];
        $day_of_week = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $is_closed_holiday = $closed[6]['holiday']['is_closed'];
        $is_closed = false;
        $is_closed = $closed[$day->weekNumberInMonth - 1][$day_of_week[$day->copy()->format('N') - 1]]['is_closed'];
        if($is_closed_holiday && !$is_closed) $is_closed = array_key_exists($day->copy()->format('Y-m-d'), json_decode($holiday, true));
        return $is_closed;
    }
}
