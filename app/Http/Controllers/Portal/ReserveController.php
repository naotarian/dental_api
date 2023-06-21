<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Manage;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Http\Controllers\CommonController;
use App\Models\Reserve;
use App\Models\ReserveDetail;
use App\Models\User;
use App\Models\Staff;
use App\Models\Unit;
//Requests
use App\Http\Requests\Portal\Reserve\RegistRequest;

class ReserveController extends Controller
{
    public function calendar(CommonController $common, Request $request)
    {
        $id = $request['id'];
        $dental = Manage::where('id', $id)->with('basic_information')->with('selected_station')->with('treatments')->first();
        //本日の日付取得
        $today = Carbon::today()->toDateString();
        //カレンダーに表示する最低月
        $min_date = Carbon::today()->format('Y年n月');
        $max_date = Carbon::today()->addMonths('3')->format('Y年n月');
        //カレンダーの日付作成
        //当月の初日を取得
        $base_date = Carbon::now();
        if ($request->has('ym')) $base_date = new Carbon($request['ym']);
        $target_first = $base_date->copy()->startOfMonth();
        //当月の最終日を取得
        $target_last = $base_date->copy()->endOfMonth();
        $next_date = $base_date->copy()->addMonth()->startOfMonth()->toDateString();
        $prev_date = $base_date->copy()->subMonth()->startOfMonth()->toDateString();
        //表示する年月フォーマット
        $display_ym = $base_date->copy()->format('Y年n月');
        //月曜日から計算した曜日の差分を取得
        $w = $target_first->copy()->dayOfWeekIso - 1;
        //カレンダーの表示開始日生成
        $cal_start = $target_first->copy()->subDays($w)->toDateString();
        //月曜日から計算した曜日の差分を取得
        $w = 7 - $target_last->copy()->dayOfWeekIso;
        //カレンダーの表示終了日生成
        $cal_end = $target_last->copy()->addDays($w)->toDateString();
        //表示開始日から終了日までの日付を配列で保持
        $dates = CarbonPeriod::create($cal_start, $cal_end)->toArray();
        //日付フォーマット配列初期化
        $dates_format = [];
        //曜日番号を曜日に紐づける配列取得
        $number_to_week = config('app.number_to_week');
        //休診日の取得
        $closed = $dental['basic_information']['closed'];
        foreach ($dates as $date) {
            //表示用の形式にフォーマット
            $dates_format[$date->format('Y/m/d')]['date'] = $date->format('n/j');
            $dates_format[$date->format('Y/m/d')]['day'] = $date->isoFormat('YYYY年MM月DD日(ddd)');
            $dates_format[$date->format('Y/m/d')]['day_ymd'] = $date->format('Y-m-d');
            //過去フラグセット
            $dates_format[$date->format('Y/m/d')]['is_past'] = false;
            if ($date->toDateString() < $today) $dates_format[$date->format('Y/m/d')]['is_past'] = true;
            //曜日番号を取得
            $dow = $date->dayOfWeekIso;
            //曜日セット
            $dates_format[$date->format('Y/m/d')]['dow'] = $dow;
            //該当月で何週目か取得
            $number_of_week = $date->weekNumberInMonth;
            //休診情報から、該当日が休診か判定
            $is_closed = $closed[$number_of_week - 1][$number_to_week[$dow - 1]]['is_closed'];
            //該当日が祝日か判定
            $is_holiday = $common->isHoliday($date);
            //祝日フラグセット
            $dates_format[$date->format('Y/m/d')]['is_holiday'] = $is_holiday;
            //医院の祝日設定が休診かつ該当日が祝日の場合は休診フラグの上書き
            if ($is_holiday && $closed[6]['holiday']['is_closed']) $is_closed = true;
            //休診フラグセット
            $dates_format[$date->format('Y/m/d')]['is_closed'] = $is_closed;
            $threshold = $common->__threshold($common, $date, $closed, $dental['id']);
            $dates_format[$date->format('Y/m/d')]['threshold'] = $threshold ? array_sum($threshold) : $threshold;
            //曜日、祝日によって文字色セット
            $dates_format[$date->format('Y/m/d')]['color'] = '#333';
            if ($dow === 6) $dates_format[$date->format('Y/m/d')]['color'] = '#1e90ff';
            if ($dow === 7) $dates_format[$date->format('Y/m/d')]['color'] = '#ff0000';
            if ($is_holiday) $dates_format[$date->format('Y/m/d')]['color'] = '#ff0000';
        }
        //配列を7つ(週ごと)で区切る
        $split_dates = array_chunk($dates_format, 7);
        //診療時間を作成
        //予約可能な時間帯を配列にする
        $business_start = $dental['basic_information']['business_start'];
        $business_end = $dental['basic_information']['business_end'];
        // $date_list = $common->__threshold($common, $date, $closed, $dental['id']);
        $date_list = $common->is_reserve_day_list($business_start, $business_end);

        $contents = ['dates' => $split_dates, 'display_ym' => $display_ym, 'next_date' => $next_date, 'prev_date' => $prev_date, 'min_date' => $min_date, 'max_date' => $max_date, 'date_list' => $date_list];
        return response()->json($contents);
    }

    public function day_list(CommonController $common, Request $request)
    {
        \Log::info($request);
        $dental = Manage::where('id', $request['manageId'])->first();
        $business_start = $dental['basic_information']['business_start'];
        $business_end = $dental['basic_information']['business_end'];
        $date_list = $common->is_reserve_day_list($business_start, $business_end);
        $closed = $dental['basic_information']['closed'];
        $day = new Carbon($request['reserveDayYmd']);
        $date_list = $common->__threshold($common, $day, $closed, $request['manageId']);
        return response()->json($date_list);
    }

    public function regist(RegistRequest $request)
    {
        $staff = Staff::where('manage_id', $request['manageId'])->first();
        $unit = Unit::where('manage_id', $request['manageId'])->first();
        $reserve = new Reserve;
        $user = $request->user();
        $user_id = $user ? $user['id'] : User::where('is_guest', true)->first()['id'];
        $reserve['user_id'] = $user_id;
        $reserve['manage_id'] = $request['manageId'];
        $reserve['staff_id'] = $staff['id'];
        $reserve['unit_id'] = $unit['id'];
        $reserve['reserve_date'] = $request['reserveDayYmd'];
        $reserve['start_time'] = $request['reserveTime'];
        $reserve['end_time'] = $request['reserveTime'];
        $reserve->save();
        $reserve_detail = new ReserveDetail;
        $reserve_detail['reserve_id'] = $reserve['id'];
        $reserve_detail['color_id'] = 1;
        $reserve_detail['category_id'] = $request['medicalHopeId'];
        $reserve_detail['last_name'] = $request['lastName'];
        $reserve_detail['first_name'] = $request['firstName'];
        $reserve_detail['last_name_kana'] = $request['lastNameKana'];
        $reserve_detail['first_name_kana'] = $request['firstNameKana'];
        $reserve_detail['full_name'] = $request['lastName'] . $request['firstName'];
        $reserve_detail['full_name_kana'] = $request['lastNameKana'] . $request['firstNameKana'];
        $reserve_detail['gender'] = $request['sex'] === 'women' ? 1 : 2;
        $reserve_detail['email'] = $request['email'];
        $reserve_detail['mobile_tel'] = $request['mobile'];
        $reserve_detail['fixed_tel'] = $request['fixed'];
        $reserve_detail['remark'] = $request['remark'];
        $reserve_detail['examination'] = $request['examination'] === 'new' ? 1 : 2;
        $reserve_detail['birth'] = $request['year'] . '-' . $request['month'] . '-' . $request['day'];
        $reserve_detail->save();
        //メール処理
        return response()->json(['res' => 'ok']);
    }
}
