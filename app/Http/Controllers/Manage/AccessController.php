<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StationCompany;
use App\Models\StationLine;
use App\Models\Station;
use App\Models\SelectedStation;

class AccessController extends Controller
{
    public function fetch()
    {
        //ユーザーID取得
        $manage_id = Auth::id();
        $station_companies = StationCompany::all();
        $station_lines = null;
        $stations = null;
        $selected = SelectedStation::where('manage_id', $manage_id)->first();
        if (!$selected) return ['station_companies' => $station_companies, 'station_lines' => $station_lines, 'stations' => $stations, 'selected' => $selected];
        if ($selected['company_code'] && $selected['line_code'] && $selected['station_code']) {
            //鉄道会社、路線、駅全て設定があった場合
            $station_lines = StationLine::where('company_code', $selected['company_code'])->get();
            $stations = Station::where('line_code', $selected['line_code'])->get();
        }
        $content = ['station_companies' => $station_companies, 'station_lines' => $station_lines, 'stations' => $stations, 'selected' => $selected];
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
    public function update(Request $request)
    {
        //ユーザーID取得
        $manage_id = Auth::id();
        $target = SelectedStation::where('manage_id', $manage_id)->first();
        //レコードがない場合は作成
        if (!$target) {
            $target = new SelectedStation();
            $target['manage_id'] = $manage_id;
        }
        $target['remark'] = $request['stationRemark'];
        if ($request['selectedStationCompanies'] && $request['selectedStationLines'] && $request['selectedStation']) {
            //鉄道会社、路線、駅全て入力があった場合のみ更新
            $station = Station::where('station_code', $request['selectedStation'])->first();
            $target['company_code'] = $request['selectedStationCompanies'];
            $target['line_code'] = $request['selectedStationLines'];
            $target['station_code'] = $request['selectedStation'];
            $target['station_group_code'] = $station['station_group_code'];
        }
        $is_changed = $target->isDirty();
        if ($is_changed) $target->save();
        return $is_changed;
    }
}
