<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Manage;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function fetch()
    {
        $manage_id = Auth::id();
        $fetch = Manage::where('id', $manage_id)->with('day_of_weeks')->first();
        $content = ['fetch' => $fetch];
        return response()->json($content);
    }
    public function update(Request $request)
    {
        $manage_id = Auth::id();
        $target = Manage::where('id', $manage_id)->first();
        $target->day_of_weeks()->sync($request['dowNumber']);
        return response()->noContent();
    }
}
