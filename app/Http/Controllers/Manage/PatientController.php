<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function fetch()
    {
        $manage_id = Auth::id();
        $patients = Patient::where('manage_id', $manage_id)->whereNotNull('patient_number')->get();
        $patients_not_number = Patient::where('manage_id', $manage_id)->whereNull('patient_number')->get();
        $contents = ['patients' => $patients, 'patients_not_number' => $patients_not_number];
        return response()->json($contents);
    }

    public function detail(Request $request)
    {
        $target = Patient::find($request['id']);
        $birth_year = '';
        $birth_month = '';
        $birth_day = '';
        if ($target['birth']) {
            $tmp_birth = explode('-', $target['birth']);
            $birth_year = $tmp_birth[0];
            $birth_month = $tmp_birth[1];
            $birth_day = $tmp_birth[2];
        }
        $target['birth_year'] = $birth_year;
        $target['birth_month'] = $birth_month;
        $target['birth_day'] = $birth_day;
        return response()->json($target);
    }

    public function update(Request $request)
    {
        $data = $request['detail'];
        $target = Patient::find($data['id']);
        $target['birth'] = $data['birth_year'] && $data['birth_month'] && $data['birth_day'] ? $data['birth_year'] . '-' . $data['birth_month'] . '-' . $data['birth_day'] : null;
        $target['patient_number'] = $data['patient_number'];
        $target['last_name'] = $data['last_name'];
        $target['first_name'] = $data['first_name'];
        $target['last_name_kana'] = $data['last_name_kana'];
        $target['first_name_kana'] = $data['first_name_kana'];
        $target['gender'] = $data['gender'];
        $target['mobile_tel'] = $data['mobile_tel'];
        $target['fixed_tel'] = $data['fixed_tel'];
        $target['email'] = $data['email'];
        $target['remark'] = $data['remark'];
        $target->save();
        return response()->noContent();
    }
}
