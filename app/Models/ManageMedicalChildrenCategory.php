<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageMedicalChildrenCategory extends Model
{
    use HasFactory;
    protected $table = 'manage_medical_children_category';

    public function category()
    {
        return $this->hasOne(MedicalChildrenCategory::class, 'id', 'medical_children_category_id');
    }
}
