<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//models
use App\Models\Unit;
use App\Models\ManageMedicalChildrenCategory;

class UnitController extends Controller
{
    public function fetch()
    {
        $contents = $this->__initial_fetch();
        return response()->json($contents);
    }

    public function update(Request $request)
    {
        $manage_id = Auth::id();
        $kind = $request['kind'];
        $data = $request['data'];
        $target = $kind === 'edit' ? $target = Unit::find($request['id']) : new Unit();
        $target->name = $data['name'];
        $target->display_name = $data['display_name'] ? $data['display_name'] : $data['name'];
        $target->display_order = $data['display_order'];
        $target->priority = $data['priority'];
        $target->status = $data['status'];
        if ($kind === 'new') $target->manage_id = $manage_id;
        $is_change = $target->isDirty();
        if ($is_change) $target->save();
        $target->treatments()->sync($request['treatCheckList']);
        $content = $this->__initial_fetch();
        $content['is_change'] = $is_change;
        return response()->json($content);
    }

    public function delete(Request $request)
    {
        $target = Unit::find($request['id']);
        $target->treatments()->sync([]);
        $target->delete();
        $content = $this->__initial_fetch();
        return response()->json($content);
    }
    public function __initial_fetch()
    {
        $manage_id = Auth::id();
        $units = Unit::where('manage_id', $manage_id)->with('treatments')->get();
        $treats = ManageMedicalChildrenCategory::where('manage_id', $manage_id)->with('category')->get();
        $unit_treats = [];
        foreach ($units as $unit) {
            $unit_treats[$unit['id']] = [];
            foreach ($unit['treatments'] as $e) {
                array_push($unit_treats[$unit['id']], $e['id']);
            }
        }
        $contents = ['units' => $units, 'treat' => $treats, 'unit_treats' => $unit_treats];
        return $contents;
    }
}
