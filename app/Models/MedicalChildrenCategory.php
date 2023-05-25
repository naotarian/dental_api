<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalChildrenCategory extends Model
{
    use HasFactory;
    use softDeletes;
    public function manages()
    {
        return $this->belongsToMany(Manage::class)->withTimestamps();
    }
    public function staffs()
    {
        return $this->belongsToMany(Staff::class)->withTimestamps();
    }
}
