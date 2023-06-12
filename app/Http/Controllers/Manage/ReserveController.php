<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reserve;

class ReserveController extends Controller
{
    public function list()
    {
        $manage_id = Auth::id();
        $reserves = Reserve::where('manage_id', $manage_id)->with('detail')->get();
        $contents = ['list' => $reserves];
        return response()->json($contents);
    }

    public function detail(Request $request)
    {
        $reserve = Reserve::where('id', $request['id'])->with('detail')->first();
        $contents = ['reserve' => $reserve];
        return response()->json($contents);
    }
}
