<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Reserve;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\StaffColor;
use App\Models\Staff;
use App\Models\MedicalChildrenCategory;

class ReserveCalendarController extends Controller
{
    public function fetch(Request $request)
    {
        $manage_id = Auth::id();
        $staffs = Staff::where('manage_id', $manage_id)->with('reserves')->get();
        $contents = ['staffs' => [], 'reserves' => []];
        foreach ($staffs as $staff) {
            $staff_color = StaffColor::where('id', $staff['color_id'])->first()['color_code'];
            $tmp = ['id' => $staff['id'], 'title' => $staff['nick_name'], 'eventColor' => $staff_color];
            array_push($contents['staffs'], $tmp);
        }
        unset($tmp);
        $reserves = Reserve::where('manage_id', $manage_id)->with('detail')->get();
        foreach ($reserves as $reserve) {
            $reserve['resourceId'] = $reserve['staff_id'];
            $reserve['start'] = '2023-06-22T14:00:00';
            $reserve['end'] = '2023-06-22T16:00:00';
            $reserve['title'] = MedicalChildrenCategory::where('id', $reserve['detail']['category_id'])->first()['title'];
            array_push($contents['reserves'], $reserve);
        }
        $categories = MedicalChildrenCategory::all();
        $contents['categories'] = $categories;
        return response()->json($contents);
    }
}
