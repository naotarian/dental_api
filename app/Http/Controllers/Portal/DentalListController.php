<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Prefecture;
use App\Models\Manage;
use App\Models\MedicalParentCategory;
use App\Models\MedicalChildrenCategory;
use App\Models\DayOfWeek;
use App\Models\Manage\BasicInformation;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Http\Controllers\CommonController;

class DentalListController extends Controller
{
    public function fetch(CommonController $common, Request $request)
    {
        $dentals = Manage::query();
        if ($request->has('prefecture')) {
            if (!empty($request['prefecture'])) {
                $dentals = $dentals->where('prefecture_number', $request['prefecture']);
            }
        }
        if ($request->has('treat')) {
            if (!empty($request['treat'])) {
                $dentals = $dentals->withWhereHas('medical_treatments', function ($query) use ($request) {
                    $query->whereIn('medical_children_category_id', $request['treat']);
                });
            }
        }
        if ($request->has('checkDow')) {
            if (!empty($request['checkDow'])) {
                $dentals = $dentals->withWhereHas('day_of_weeks', function ($query) use ($request) {
                    $query->whereIn('day_of_week_id', $request['checkDow']);
                });
            }
        }
        $dentals = $dentals->withWhereHas('basic_information', function ($query) {
            $query->whereNotNull('business_start')->whereNotNull('business_end');
        })->with('selected_station')->with('medical_treatments')->get()->toArray();
        //DentalCardに表示するミニカレンダー作成
        //当日
        $today = Carbon::today();
        $end_date = $today->copy()->addWeeks(3);
        $dates = CarbonPeriod::create($today, $end_date)->toArray();
        foreach ($dentals as $key => &$dental) {
            $dental['calendarMin'] = [];
            $closed = BasicInformation::where('manage_id', $dental['id'])->first();
            $closed = $closed['closed'];
            foreach ($dates as $index => $date) {
                $dental['calendarMin'][$index]['day'] = $date->format('Y-m-d');
                $dental['calendarMin'][$index]['display_day'] = $date->format('n/j');
                $dental['calendarMin'][$index]['dow_number'] = $date->dayOfWeekIso;
                $dental['calendarMin'][$index]['dow'] = $date->isoFormat('ddd');
                $dental['calendarMin'][$index]['is_holiday'] = $common->isHoliday($date);
                $threshold = $this->__threshold($common, $date, $closed, $dental['id']);
                $dental['calendarMin'][$index]['threshold'] = $threshold ? array_sum($threshold) : $threshold;
                $dental['calendarMin'][$index]['today'] = $key === 0 ? true : false;
            }
        }
        $regions = Region::with('prefectures')->get();
        $categories = MedicalParentCategory::with('children')->get();
        $children_categories = MedicalChildrenCategory::all();
        $prefectures = Prefecture::all();
        $dow = DayOfWeek::all();
        $contents = ['regions' => $regions, 'dentals' => $dentals, 'categories' => $categories, 'children_categories' => $children_categories, 'prefectures' => $prefectures, 'dow' => $dow];
        return response()->json($contents);
    }

    public function detail(CommonController $common, Request $request)
    {
        $id = $request['id'];
        $dental = Manage::where('id', $id)->with('basic_information')->with('selected_station')->with('treatments')->first();
        //当日
        $today = Carbon::today();
        $end_date = $today->copy()->addWeeks(3);
        $dates = CarbonPeriod::create($today, $end_date)->toArray();
        $days = [];
        foreach ($dates as $index => $date) {
            $days[$date->format('Y-m-d')] = ['day_format' => $date->format('n/j')];
        }

        $contents = ['dental' => $dental, 'days' => $days];
        return response()->json($contents);
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
}
