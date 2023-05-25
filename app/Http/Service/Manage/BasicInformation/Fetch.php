<?php

namespace App\Http\Service\Manage\BasicInformation;
use App\Models\Manage\BasicInformation;
use Illuminate\Support\Facades\Auth;
class Fetch {
  public function __invoke() {
    //ユーザーID取得
    $manage_id = Auth::id();
    //休診情報のレコード取得
    $basic_information = BasicInformation::where('manage_id', $manage_id)->first()->toArray();
    $holiday = $basic_information['closed'][6];
    unset($basic_information['closed'][6]);
    $contents = ['basic_information' => $basic_information, 'holiday' => $holiday];
    return $contents;
  }
}