<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Unit extends Model
{
    use HasFactory;
    use softDeletes;
    use HasUuids;
    protected $fillable = [
        'manage_id',
        'name',
        'display_name',
        'display_order',
        'priority',
        'status'
    ];
    public function medical_treatments()
    {
        return $this->belongsToMany(MedicalChildrenCategory::class)
            ->withPivot('medical_children_category_id');
    }
    public function treatments()
    {
        return $this->belongsToMany(MedicalChildrenCategory::class)->withTimestamps();
    }
}
