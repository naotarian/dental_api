<?php

namespace App\Models\Manage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class BasicInformation extends Model
{
    use HasFactory;
    use softDeletes;
    use HasUuids;
    protected $table = 'basic_information';
    protected $fillable = [
        'manage_id',
        'closed',
    ];
    protected $casts = [
        'closed'  => 'json',
    ];
}
