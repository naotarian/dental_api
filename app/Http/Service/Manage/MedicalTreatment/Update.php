<?php

namespace App\Http\Service\Manage\MedicalTreatment;
use Illuminate\Support\Facades\Auth;
use App\Models\Manage;
class Update {
  public function __invoke($data) {
    $treat_list = $data['checkList'];
    //ユーザーID取得
    $manage_id = Auth::id();
    $manage = Manage::find($manage_id);
    $manage->treatments()->sync($treat_list);
    return true;
  }
}