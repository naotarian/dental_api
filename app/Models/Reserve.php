<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Reserve extends Model
{
    use HasFactory;
    use softDeletes;
    use HasUuids;
    public function detail()
    {
        return $this->hasOne(ReserveDetail::class);
    }
}
