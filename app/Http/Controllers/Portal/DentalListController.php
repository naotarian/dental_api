<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Manage;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DentalListController extends Controller
{
    public function fetch()
    {
        $dentals = Manage::with('selected_station')->get();
        $regions = Region::with('prefectures')->get();
        $contents = ['regions' => $regions, 'dentals' => $dentals];
        return response()->json($contents);
    }

    public function detail(Request $request)
    {
        $id = $request['id'];
        $dental = Manage::where('id', $id)->with('selected_station')->with('treatments')->first();
        //カレンダーの日付作成
        //当月の初日を取得
        $target_first = Carbon::now()->startOfMonth();
        //月曜日から計算した曜日の差分を取得
        $w = $target_first->copy()->dayOfWeekIso - 1;
        $cal_start = $target_first->copy()->subDays($w)->toDateString();

        //当月の最終日を取得
        $target_last = Carbon::now()->endOfMonth();

        //月曜日から計算した曜日の差分を取得
        $w = 7 - $target_last->copy()->dayOfWeekIso;
        $cal_end = $target_last->copy()->addDays($w)->toDateString();
        $dates = CarbonPeriod::create($cal_start, $cal_end)->toArray();
        $dates_format = [];
        foreach ($dates as $date) {
            $dates_format[$date->format('Y/m/d')]['date'] = $date->format('n/j');
            $dates_format[$date->format('Y/m/d')]['dow'] = $date->dayOfWeekIso;
        }
        $split_dates = array_chunk($dates_format, 7);
        \Log::info($dates);
        $contents = ['dental' => $dental, 'dates' => $split_dates];
        return response()->json($contents);
    }
}
