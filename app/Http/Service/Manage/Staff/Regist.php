<?php

namespace App\Http\Service\Manage\Staff;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
class Regist {
  public function __invoke($data) {
    //ユーザーID取得
    $manage_id = Auth::id();
    $target = $data['staffId'] ? Staff::find($data['staffId']) : new Staff();
    $target->manage_id = $manage_id;
    $target->staff_number = $data['staffNumber'];
    $target->last_name = $data['lastName'];
    $target->first_name = $data['firstName'];
    $target->last_name_kana = $data['lastNameKana'];
    $target->first_name_kana = $data['firstNameKana'];
    $target->nick_name = $data['nickName'];
    $target->gender = $data['gender'];
    $target->color_id = $data['staffColor'];
    $target->display_order = $data['displayOrder'];
    $target->priority = $data['priority'];
    $target->save();
    $target->treatments()->sync($data['treatCheckList']);
    return true;
  }
}