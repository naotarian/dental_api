<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalParentCategory extends Model
{
    use HasFactory;
    use softDeletes;

    public function children()
    {
        return $this->hasMany(MedicalChildrenCategory::class, 'parent_id', 'id');
    }
}
