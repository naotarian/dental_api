<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Manage;
use App\Models\Shift;
use Illuminate\Support\Facades\Auth;
use Carbon\CarbonPeriod;
use Carbon\Carbon;

class ShiftController extends Controller
{
    public function fetch($date = null)
    {
        $manage_id = Auth::id();
        $staff = Staff::where('manage_id', $manage_id)->get();
        //当月の開始日と終了日を生成
        if($date) {
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
            $target_list[$day->copy()->format('Y-m-d')] = [
                'day' => $day->copy()->format('n月j日'),
                'dow' => $day->copy()->format('N'),
                'day_format' => $day->copy()->format('Y-m-d')
            ];
        }
        $date = new Carbon($start_of_month);
        $target_month = $date->copy()->month;
        $target_year = $date->copy()->year;

        // $staff = Manage::where('id', $manage_id)->with('staff', function($query) {
        //     $query->with('shifts');
        // })->get();
        $staff_ids = [];
        $staffs = Manage::where('id', $manage_id)->with('staff')->first();
        if($staffs['staff']) {
            foreach($staffs['staff'] as $data) {
                array_push($staff_ids, $data['id']);
            }
        }
        $shifts = [];
        foreach($target_list as $key => $d) {
            $shifts[$key] = Shift::where('date', $key)->whereIn('staff_id', $staff_ids)->get()->toArray();
        }
        // \Log::info(json_decode($staff,true));
        $content = ['staff' => $staff, 'days' => $target_list,'target_year' => $target_year, 'target_month' => $target_month, 'shifts' => $shifts];
        return response()->json($content);
    }
}
