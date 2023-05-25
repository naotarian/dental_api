<?php

namespace App\Http\Service\Manage\Access;
use App\Models\StationCompany;
use App\Models\StationLine;
use App\Models\Station;
use App\Models\SelectedStation;
use Illuminate\Support\Facades\Auth;
class Fetch {
  public function __invoke() {
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
}