<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StaffColor;
use App\Models\Staff;
use App\Models\MedicalChildrenCategory;
use App\Models\ManageMedicalChildrenCategory;

class StaffController extends Controller
{
    public function fetch()
    {
        $content = $this->__fetchInitial();
        return response()->json($content);
    }

    public function regist(Request $request)
    {
        //ユーザーID取得
        $manage_id = Auth::id();
        $target = $request['staffId'] ? Staff::find($request['staffId']) : new Staff();
        $target->manage_id = $manage_id;
        $target->staff_number = $request['staffNumber'];
        $target->last_name = $request['lastName'];
        $target->first_name = $request['firstName'];
        $target->last_name_kana = $request['lastNameKana'];
        $target->first_name_kana = $request['firstNameKana'];
        $target->nick_name = $request['nickName'];
        $target->gender = $request['gender'];
        $target->color_id = $request['staffColor'];
        $target->display_order = $request['displayOrder'];
        $target->priority = $request['priority'];
        $target->save();

        $target->treatments()->sync($request['treatCheckList']);
        $content = $this->__fetchInitial();
        return response()->json($content);
    }

    public function delete(Request $request)
    {
        $target = Staff::find($request['id']);
        $target->treatments()->sync([]);
        $target->delete();
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
