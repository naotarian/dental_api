<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StaffColor;

class StaffController extends Controller
{
    public function fetch()
    {
        $colors = StaffColor::all();
        $content = ['colors' => $colors];
        return response()->json($content);
    }

    public function regist(Request $request)
    {
        \Log::info($request);
    }
}
