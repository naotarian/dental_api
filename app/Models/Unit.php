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
}
