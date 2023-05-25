<?php

namespace App\Http\Service\Manage\Access;
use App\Models\StationCompany;
use App\Models\StationLine;
use App\Models\Station;
use App\Models\SelectedStation;
use Illuminate\Support\Facades\Auth;
class Update {
  public function __invoke($data) {
    //ユーザーID取得
    $manage_id = Auth::id();
    $target = SelectedStation::where('manage_id', $manage_id)->first();
    //レコードがない場合は作成
    if (!$target) {
        $target = new SelectedStation();
        $target['manage_id'] = $manage_id;
    }
    $target['remark'] = $data['stationRemark'];
    if ($data['selectedStationCompanies'] && $data['selectedStationLines'] && $data['selectedStation']) {
        //鉄道会社、路線、駅全て入力があった場合のみ更新
        $station = Station::where('station_code', $data['selectedStation'])->first();
        $target['company_code'] = $data['selectedStationCompanies'];
        $target['line_code'] = $data['selectedStationLines'];
        $target['station_code'] = $data['selectedStation'];
        $target['station_group_code'] = $data['station_group_code'];
    }
    $is_changed = $target->isDirty();
    if ($is_changed) $target->save();
    return $is_changed;
  }

}