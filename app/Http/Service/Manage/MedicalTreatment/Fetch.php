<?php

namespace App\Http\Service\Manage\MedicalTreatment;
use Illuminate\Support\Facades\Auth;
use App\Models\MedicalParentCategory;
use App\Models\Manage;
class Fetch {
  public function __invoke() {
    $categories = MedicalParentCategory::with('children')->get();
    //ユーザーID取得
    $manage_id = Auth::id();
    $manage = Manage::find($manage_id);
    $manage_treats = $manage->medical_treatments()->get();
    $default_checks = [];
    if($manage_treats) {
        foreach($manage_treats as $manage_treat) {
            array_push($default_checks, $manage_treat['pivot']['medical_children_category_id']);
        }
    }
    $content = ['categories' => $categories, 'default_checks' => $default_checks];
    return $content;
  }
}