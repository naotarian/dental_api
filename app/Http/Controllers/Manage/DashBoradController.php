<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Shift;
use App\Models\Staff;
use App\Models\Reserve;
use Carbon\Carbon;

class DashBoradController extends Controller
{
    public function fetch()
    {
        $manage_id = Auth::id();
        $today = Carbon::today();
        //今日のスタッフごとのシフト
        $today_shifts = Staff::where('manage_id', $manage_id)->withWhereHas('shifts', function ($query) use ($today) {
            $query->where('date', $today->format('Y-m-d'));
        })->get();
        //今日入っている予約
        $today_reserves = Reserve::where('manage_id', $manage_id)->where('reserve_date', $today->format('Y-m-d'))->with('detail', function ($query) {
            $query->with('category');
        })->get();
        //チャートに表示するデータ作成(当月初日から6ヶ月前 ~ 3ヶ月後を表示)
        //半年前
        $start_month = $today->copy()->subMonthsNoOverflow(6)->startOfMonth();
        //3ヶ月後
        $end_month = $today->copy()->addMonthsNoOverflow(3)->startOfMonth();
        $chart_data = [];
        while ($start_month < $end_month) {
            $target_month_start = $start_month->copy();
            $target_month_end = $start_month->copy()->endOfMonth();
            $reserve_count = Reserve::where('manage_id', $manage_id)->whereBetween('reserve_date', [$target_month_start, $target_month_end])->count();
            $reserve_cancel_count = Reserve::where('manage_id', $manage_id)->whereNotNull('cancel_date')->whereBetween('reserve_date', [$target_month_start, $target_month_end])->count();
            $tmp_data = ['name' => $start_month->copy()->format('Y-m'), '予約件数' => $reserve_count, 'キャンセル数' => $reserve_cancel_count];
            array_push($chart_data, $tmp_data);
            $start_month->addMonthNoOverflow();
        }
        $contents = ['shifts' => $today_shifts, 'reserves' => $today_reserves, 'chart_data' => $chart_data];
        return response()->json($contents);
    }
}
