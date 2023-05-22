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
        $content = ['basic_information' => $basic_information];
        return response()->json($content);
    }
    public function update(Request $request)
    {
        //ユーザーID取得
        $manage_id = Auth::id();
        //休診情報のレコード取得
        $closed = BasicInformation::where('manage_id', $manage_id)->first();
        //レコードなければ作成
        if (!$closed) $closed = new BasicInformation();
        $closed['closed'] = $request->closed;
        $closed['business_start'] = $request->businessStart;
        $closed['business_end'] = $request->businessEnd;
        $closed['manage_id'] = $manage_id;
        //変更あれば保存
        if ($closed->isDirty()) $closed->save();
    }
}
