<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reserve;
use Carbon\Carbon;

class ReserveController extends Controller
{
    public function list()
    {
        $manage_id = Auth::id();
        $reserves = Reserve::where('manage_id', $manage_id)->with('detail')->get();
        $contents = ['list' => $reserves];
        return response()->json($contents);
    }
    public function listSearch(Request $request)
    {
        $manage_id = Auth::id();
        $reserves = Reserve::query();
        $reserves = $reserves->where('manage_id', $manage_id);
        if($request['todayOnly']) {
            $today = Carbon::today();
            $reserves = $reserves->where('reserve_date', $today->format('Y-m-d'));
        }
        $reserves = $reserves->with('detail')->get();
        $contents = ['list' => $reserves];
        return response()->json($contents);
    }

    public function detail(Request $request)
    {
        $reserve = Reserve::where('id', $request['id'])->with('staff')->with('unit')->with('detail', function($query) {
            $query->with('category');
        })->first();
        $contents = ['reserve' => $reserve];
        return response()->json($contents);
    }
}
