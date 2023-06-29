<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\StaffColor;
use App\Models\Staff;
use App\Models\Unit;
use App\Models\User;
use App\Models\Reserve;
use App\Models\ReserveDetail;
use App\Models\MedicalChildrenCategory;
use App\Http\Requests\Manage\ReserveCalendar\RegistRequest;

class ReserveCalendarController extends Controller
{
    public function defaultFetch()
    {
        $manage_id = Auth::id();
        $staffs = Staff::where('manage_id', $manage_id)->with('reserves')->get();
        $contents = ['staffs' => [], 'reserves' => [], 'units' => []];
        foreach ($staffs as $staff) {
            $staff_color = StaffColor::where('id', $staff['color_id'])->first()['color_code'];
            $tmp = ['id' => $staff['id'], 'title' => $staff['nick_name'], 'eventColor' => $staff_color];
            array_push($contents['staffs'], $tmp);
        }
        unset($tmp);
        $reserves = Reserve::where('manage_id', $manage_id)->with('detail')->get();
        foreach ($reserves as $reserve) {
            $reserve['reserveId'] = $reserve['id'];
            $reserve['resourceId'] = $reserve['staff_id'];
            $reserve['start'] = $reserve['reserve_date'] . 'T' . $reserve['start_time'];
            $reserve['end'] = $reserve['reserve_date'] . 'T' . $reserve['end_time'];
            $reserve['title'] = MedicalChildrenCategory::where('id', $reserve['detail']['category_id'])->first()['title'];
            array_push($contents['reserves'], $reserve);
        }
        $categories = MedicalChildrenCategory::all();
        $contents['categories'] = $categories;
        $units = Unit::where('manage_id', $manage_id)->where('status', 'S')->get();
        $contents['units'] = $units;
        return $contents;
    }
    public function fetch()
    {
        $contents = $this->defaultFetch();
        return response()->json($contents);
    }

    public function regist(RegistRequest $request)
    {
        $data = $request->all();
        $manage_id = Auth::id();
        if ($data['id']) {
            $target = Reserve::where('id', $data['id'])->with('detail')->first();
            $target['unit_id'] = $data['unit'];
            $target['staff_id'] = $data['staff'];
            $target['reserve_date'] = $data['reserveDay'];
            $target['start_time'] = $data['startTime'];
            $target['end_time'] = $data['endTime'];
            $is_save = $target->save();
            if ($is_save) {
                $detail = ReserveDetail::where('reserve_id', $data['id'])->first();
                $detail->category_id = $data['category'];
                $detail->last_name = $data['lastName'];
                $detail->first_name = $data['firstName'];
                $detail->full_name = ($data['lastName'] && $data['firstName']) ? $data['lastName'] . $data['firstName'] : null;
                $detail->last_name_kana = $data['lastNameKana'];
                $detail->first_name_kana = $data['firstNameKana'];
                $detail->full_name_kana = ($data['lastNameKana'] && $data['firstNameKana']) ? $data['lastNameKana'] . $data['firstNameKana'] : null;
                $detail->gender = $data['gender'];
                $detail->mobile_tel = $data['mobileTel'];
                $detail->fixed_tel = $data['fixedTel'];
                $detail->email = $data['email'];
                $detail->birth = ($data['birthYear'] && $data['birthMonth'] && $data['birthDay']) ? $data['birthYear'] . '-' . $data['birthMonth'] . '-' . $data['birthDay'] : null;
                $detail->examination = $data['examination'];
                $detail->remark = $data['remark'];
                $detail->save();
            }
        } else {
            $guest = User::where('is_guest', true)->first();
            $reserve = new Reserve;
            $reserve->manage_id = $manage_id;
            $reserve->staff_id = $data['staff'];
            $reserve->unit_id = $data['unit'];
            $reserve->user_id = $guest['id'];
            $reserve->reserve_date = $data['reserveDay'];
            $reserve->start_time = $data['startTime'];
            $reserve->end_time = $data['endTime'];
            $save = $reserve->save();
            if ($save) {
                $detail = new ReserveDetail;
                $detail->reserve_id = $reserve['id'];
                $detail->color_id = 1;
                $detail->category_id = $data['category'];
                $detail->last_name = $data['lastName'];
                $detail->first_name = $data['firstName'];
                $detail->full_name = ($data['lastName'] && $data['firstName']) ? $data['lastName'] . $data['firstName'] : null;
                $detail->last_name_kana = $data['lastNameKana'];
                $detail->first_name_kana = $data['firstNameKana'];
                $detail->full_name_kana = ($data['lastNameKana'] && $data['firstNameKana']) ? $data['lastNameKana'] . $data['firstNameKana'] : null;
                $detail->gender = $data['gender'];
                $detail->mobile_tel = $data['mobileTel'];
                $detail->fixed_tel = $data['fixedTel'];
                $detail->email = $data['email'];
                $detail->birth = ($data['birthYear'] && $data['birthMonth'] && $data['birthDay']) ? $data['birthYear'] . '-' . $data['birthMonth'] . '-' . $data['birthDay'] : null;
                $detail->examination = $data['examination'];
                $detail->remark = $data['remark'];
                $detail->save();
            }
        }
        $contents = $this->defaultFetch();
        return response()->json($contents);
    }

    public function drag(Request $request)
    {
        $data = $request->all();
        $target = Reserve::where('id', $request['reserveId'])->first();
        if ($data['staffId']) $target['staff_id'] = $data['staffId'];
        $target['reserve_date'] = $data['reserveDay'];
        $target['start_time'] = $data['startTime'];
        $target['end_time'] = $data['endTime'];
        $changed = $target->isDirty();
        if ($changed) $target->save();
        $contents = $this->defaultFetch();
        return response()->json($contents);
    }
}
