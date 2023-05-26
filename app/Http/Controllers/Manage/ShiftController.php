<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Carbon\CarbonPeriod;
use Carbon\Carbon;

class ShiftController extends Controller
{
    public function fetch()
    {
        $manage_id = Auth::id();
        $staff = Staff::where('manage_id', $manage_id)->get();
        //当月の開始日と終了日を生成
        $start_of_month = Carbon::now()->startOfMonth()->toDateString();
        $end_of_month = Carbon::now()->endOfMonth()->toDateString();
        $target_days = CarbonPeriod::create($start_of_month, $end_of_month)->toArray();
        $target_list = [];
        foreach ($target_days as $day) {
            $target_list[$day->copy()->format('Y-m-d')] = [
                'day' => $day->copy()->format('Y-n-j'),
                'dow' => $day->copy()->format('N')
            ];
        }
        \Log::info($target_list);
        $content = ['staff' => $staff, 'days' => $target_list];
        // \Log::info($target_days);
        return response()->json($content);
    }
}
