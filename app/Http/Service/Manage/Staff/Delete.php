<?php

namespace App\Http\Service\Manage\Staff;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
class Delete {
  public function __invoke($data) {
    $target = Staff::find($data['id']);
    $target->treatments()->sync([]);
    $target->delete();
    return true;
  }
}