<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Manage;

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
        $contents = ['dental' => $dental];
        return response()->json($contents);
    }
}
