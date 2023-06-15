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
    public function fetch(Request $request)
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
        })->with('selected_station')->get();
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
