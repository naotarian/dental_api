<?php

namespace App\Http\Controllers\Manage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StaffColor;
use App\Models\Staff;

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
        $content = $this->__fetchInitial();
        return response()->json($content);
    }

    public function delete(Request $request) {
        $target = Staff::find($request['id']);
        $target->delete();
        $content = $this->__fetchInitial();
        return response()->json($content);
    }

    public function __fetchInitial() {
        //ユーザーID取得
        $manage_id = Auth::id();
        $colors = StaffColor::all();
        $staff = Staff::where('manage_id', $manage_id)->get();
        $content = ['colors' => $colors, 'staff' => $staff];
        return $content;
    }
}
