<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Prefecture;
use App\Models\Manage;
use App\Models\MedicalParentCategory;
use App\Models\MedicalChildrenCategory;
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
        $dentals = $dentals->withWhereHas('basic_information', function ($query) {
            $query->whereNotNull('business_start')->whereNotNull('business_end');
        })->with('selected_station')->with('medical_treatments')->get()->toArray();
        //DentalCardに表示するミニカレンダー作成
        //当日
        $today = Carbon::today();
        $end_date = $today->copy()->addWeeks(3);
        $dates = CarbonPeriod::create($today, $end_date)->toArray();
        foreach($dentals as $key => &$dental) {
            $dental['calendarMin'] = [];
            foreach($dates as $index => $date) {
                $dental['calendarMin'][$index]['day'] = $date->format('Y/m/d');
                $dental['calendarMin'][$index]['display_day'] = $date->format('n/j');
                $dental['calendarMin'][$index]['dow_number'] = $date->dayOfWeekIso;
                $dental['calendarMin'][$index]['dow'] = $date->isoFormat('ddd');
                $dental['calendarMin'][$index]['is_holiday'] = $common->isHoliday($date);
                $dental['calendarMin'][$index]['threshold'] = $date->dayOfWeekIso;
                $dental['calendarMin'][$index]['today'] = $key === 0 ? true : false;
            }
        }
        $regions = Region::with('prefectures')->get();
        $categories = MedicalParentCategory::with('children')->get();
        $children_categories = MedicalChildrenCategory::all();
        $prefectures = Prefecture::all();
        $contents = ['regions' => $regions, 'dentals' => $dentals, 'categories' => $categories, 'children_categories' => $children_categories, 'prefectures' => $prefectures];
        return response()->json($contents);
    }

    public function detail(CommonController $common, Request $request)
    {
        $id = $request['id'];
        $dental = Manage::where('id', $id)->with('basic_information')->with('selected_station')->with('treatments')->first();
        $contents = ['dental' => $dental];
        return response()->json($contents);
    }
}
