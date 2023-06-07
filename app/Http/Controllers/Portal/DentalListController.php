<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Region;

class DentalListController extends Controller
{
    public function fetch()
    {
        \Log::info('test');
        $regions = Region::with('prefectures')->get();
        $contents = ['regions' => $regions];
        return response()->json($contents);
    }
}
