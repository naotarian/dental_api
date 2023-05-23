<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MedicalParentCategory;
use App\Models\MedicalChildrenCategory;

class MedicalTreatmentController extends Controller
{
    public function fetch()
    {
        $categories = MedicalParentCategory::with('children')->get();
        $content = ['categories' => $categories];
        return $content;
    }

    public function update(Request $request)
    {
        \Log::info($request);
    }
}
