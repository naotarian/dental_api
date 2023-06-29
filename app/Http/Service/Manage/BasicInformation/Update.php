<?php

namespace App\Http\Service\Manage\BasicInformation;

use App\Models\Manage\BasicInformation;
use Illuminate\Support\Facades\Auth;

class Update
{
  public function __invoke($data)
  {
    //ユーザーID取得
    $manage_id = Auth::id();
    //休診情報のレコード取得
    $basic_information = BasicInformation::where('manage_id', $manage_id)->first();
    //レコードなければ作成
    if (!$basic_information) $basic_information = new BasicInformation();
    \Log::info($data);
    $basic_information['closed'] = $data->closed;
    $tmp = $basic_information['closed'];
    $tmp[6]['holiday'] = $data->holiday;
    $basic_information['closed'] = $tmp;
    $basic_information['business_start'] = $data->businessStart;
    $basic_information['business_end'] = $data->businessEnd;
    $basic_information['manage_id'] = $manage_id;
    //変更あれば保存
    $is_change = $basic_information->isDirty();
    if ($is_change) $basic_information->save();
    $contents = ['is_change' => $is_change];
    return $contents;
  }
}
