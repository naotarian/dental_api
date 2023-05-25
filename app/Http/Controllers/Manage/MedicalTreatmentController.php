<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MedicalParentCategory;
use App\Models\Manage;
use Illuminate\Support\Facades\Auth;
use App\Models\ManageMedicalChildrenCategory;
//Services
use App\Http\Service\Manage\MedicalTreatment\Fetch;
use App\Http\Service\Manage\MedicalTreatment\Update;

class MedicalTreatmentController extends Controller
{
    public function fetch(Fetch $fetch)
    {
        $content = $fetch();
        return $content;
    }

    public function update(Update $update, Request $request)
    {
        $content = $update($request);
        return $content;
    }
}
