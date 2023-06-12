<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//Services
use App\Http\Service\Manage\BasicInformation\Fetch;
use App\Http\Service\Manage\BasicInformation\Update;

class BasicInformationController extends Controller
{
    public function fetch(Fetch $fetch)
    {
        $contents = $fetch();
        return response()->json($contents);
    }
    public function update(Update $update, Request $request)
    {
        $contents = $update($request);
        return response()->json($contents);
    }
}
