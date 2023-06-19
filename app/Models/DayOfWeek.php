<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayOfWeek extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function manages()
    {
        return $this->belongsToMany(Manage::class)->withTimestamps();
    }
}
