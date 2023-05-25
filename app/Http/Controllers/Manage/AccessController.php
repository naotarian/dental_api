<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StationCompany;
use App\Models\StationLine;
use App\Models\Station;
use App\Models\SelectedStation;
//Service
use App\Http\Service\Manage\Access\Fetch;
use App\Http\Service\Manage\Access\Update;

class AccessController extends Controller
{
    public function fetch(Fetch $fetch)
    {
        $content = $fetch();
        return $content;
    }

    public function company_change(Request $request)
    {
        $company = StationCompany::where('company_code', $request['companyCode'])->first();
        $station_lines = StationLine::where('company_code', $company['company_code'])->get();
        return $station_lines;
    }
    public function line_change(Request $request)
    {
        $line = StationLine::where('line_code', $request['lineCode'])->first();
        $stations = Station::where('line_code', $line['line_code'])->get();
        return $stations;
    }
    public function update(Update $update, Request $request)
    {
        $is_changed = $update($request);
        return $is_changed;
    }
}
