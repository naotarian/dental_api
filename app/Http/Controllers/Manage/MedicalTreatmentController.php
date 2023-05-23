<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MedicalParentCategory;
use App\Models\Manage;
use Illuminate\Support\Facades\Auth;
use App\Models\ManageMedicalChildrenCategory;

class MedicalTreatmentController extends Controller
{
    public function fetch()
    {
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

    public function update(Request $request)
    {
        $treat_list = $request['checkList'];
        //ユーザーID取得
        $manage_id = Auth::id();
        $manage = Manage::find($manage_id);
        $manage->treatments()->sync($treat_list);
        return true;
    }
}
