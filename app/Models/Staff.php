<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Staff extends Model
{
    use HasFactory;
    use softDeletes;
    use HasUuids;
    protected $fillable = [
        'manage_id',
        'last_name',
        'first_name',
        'last_name_kana',
        'first_name_kana',
        'nick_name',
        'gender',
        'color_id',
        'display_order',
        'priority',
    ];

    //アクセサ
    public function getLastNameAttribute($value)
    {
        return empty($value) ? null : openssl_decrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function getFirstNameAttribute($value)
    {
        return empty($value) ? null : openssl_decrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function getLastNameKanaAttribute($value)
    {
        return empty($value) ? null : openssl_decrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function getFirstNameKanaAttribute($value)
    {
        return empty($value) ? null : openssl_decrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function getNickNameAttribute($value)
    {
        return empty($value) ? null : openssl_decrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    //ミューテタ
    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = empty($value) ? null : openssl_encrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = empty($value) ? null : openssl_encrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function setLastNameKanaAttribute($value)
    {
        $this->attributes['last_name_kana'] = empty($value) ? null : openssl_encrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function setFirstNameKanaAttribute($value)
    {
        $this->attributes['first_name_kana'] = empty($value) ? null : openssl_encrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function setNickNameAttribute($value)
    {
        $this->attributes['nick_name'] = empty($value) ? null : openssl_encrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function treatments()
    {
        return $this->belongsToMany(MedicalChildrenCategory::class)->withTimestamps();
    }
    public function medical_treatments()
    {
        return $this->belongsToMany(MedicalChildrenCategory::class)
            ->withPivot('medical_children_category_id');
    }
}
