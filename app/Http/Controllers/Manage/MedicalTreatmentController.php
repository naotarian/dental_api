<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MedicalParentCategory;
use App\Models\Manage;
use Illuminate\Support\Facades\Auth;

class MedicalTreatmentController extends Controller
{
    public function fetch()
    {
        $categories = MedicalParentCategory::with('children')->get();
        $content = ['categories' => $categories];
        return $content;
    }

    public function update(Request $request)
    {
        $treat_list = $request['checkList'];
        //ユーザーID取得
        $manage_id = Auth::id();
        $manage = Manage::find($manage_id);
        $manage->treatments()->sync($treat_list);
        \Log::info($request);
    }
}
