<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//Models
use App\Models\Manage\BasicInformation;

class BasicInformationController extends Controller
{
    public function fetch()
    {
        //ユーザーID取得
        $manage_id = Auth::id();
        //休診情報のレコード取得
        $basic_information = BasicInformation::where('manage_id', $manage_id)->first();
        $contents = ['basic_information' => $basic_information];
        return response()->json($contents);
    }
    public function update(Request $request)
    {
        //ユーザーID取得
        $manage_id = Auth::id();
        //休診情報のレコード取得
        $basic_information = BasicInformation::where('manage_id', $manage_id)->first();
        //レコードなければ作成
        if (!$basic_information) $basic_information = new BasicInformation();
        $basic_information['closed'] = $request->closed;
        $basic_information['business_start'] = $request->businessStart;
        $basic_information['business_end'] = $request->businessEnd;
        $basic_information['manage_id'] = $manage_id;
        //変更あれば保存
        $is_change = $basic_information->isDirty();
        if ($is_change) $basic_information->save();
        $contents = ['is_change' => $is_change];
        return response()->json($contents);
    }
}
