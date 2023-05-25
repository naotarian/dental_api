<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StaffColor;
use App\Models\Staff;
use App\Models\MedicalChildrenCategory;
use App\Models\ManageMedicalChildrenCategory;
//Services
use App\Http\Service\Manage\Staff\Regist;
use App\Http\Service\Manage\Staff\Delete;

class StaffController extends Controller
{
    public function fetch()
    {
        $content = $this->__fetchInitial();
        return response()->json($content);
    }

    public function regist(Regist $regist, Request $request)
    {
        $registed = $regist($request);
        $content = $this->__fetchInitial();
        return response()->json($content);
    }

    public function delete(Delete $delete, Request $request)
    {
        $deleted = $delete($request);
        $content = $this->__fetchInitial();
        return response()->json($content);
    }

    public function __fetchInitial()
    {
        //ユーザーID取得
        $manage_id = Auth::id();
        $colors = StaffColor::all();
        $staff = Staff::where('manage_id', $manage_id)->with('medical_treatments')->get();
        $staff_checks = [];
        foreach ($staff as $s) {
            $staff_checks[$s['id']] = [];
            foreach ($s['medical_treatments'] as $e) {
                array_push($staff_checks[$s['id']], $e['id']);
            }
        }
        $treats = ManageMedicalChildrenCategory::where('manage_id', $manage_id)->with('category')->get();
        $all_treat = MedicalChildrenCategory::all();
        $content = ['colors' => $colors, 'staff' => $staff, 'treat' => $treats, 'all_treat' => $all_treat, 'staff_checks' => $staff_checks];
        return $content;
    }
}
