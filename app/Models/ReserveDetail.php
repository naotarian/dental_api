<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ReserveDetail extends Model
{
    use HasFactory;
    use softDeletes;
    use HasUuids;
    protected $fillable = [
        'color_id',
        'category_id',
        'last_name',
        'first_name',
        'full_name',
        'last_name_kana',
        'first_name_kana',
        'full_name_kana',
        'gender',
        'mobile_tel',
        'fixed_tel',
        'email',
        'birth',
        'examination',
        'remark',
    ];
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = empty($value) ? null : openssl_encrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = empty($value) ? null : openssl_encrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = empty($value) ? null : openssl_encrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function setLastNameKanaAttribute($value)
    {
        $this->attributes['last_name_kana'] = empty($value) ? null : openssl_encrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function setFirstNameKanaAttribute($value)
    {
        $this->attributes['first_name_kana'] = empty($value) ? null : openssl_encrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function setFullNameAttribute($value)
    {
        $this->attributes['full_name'] = empty($value) ? null : openssl_encrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function setFullNameKanaAttribute($value)
    {
        $this->attributes['full_name_kana'] = empty($value) ? null : openssl_encrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function setMobileTelAttribute($value)
    {
        $this->attributes['mobile_tel'] = empty($value) ? null : openssl_encrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function setFixedTelAttribute($value)
    {
        $this->attributes['fixed_tel'] = empty($value) ? null : openssl_encrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function setBirthAttribute($value)
    {
        $this->attributes['birth'] = empty($value) ? null : openssl_encrypt($value, config('app.aes_type'), config('app.aes_key'));
    }

    public function getLastNameAttribute($value)
    {
        return empty($value) ? null : openssl_decrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function getLastNameKanaAttribute($value)
    {
        return empty($value) ? null : openssl_decrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function getFirstNameAttribute($value)
    {
        return empty($value) ? null : openssl_decrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function getFirstNameKanaAttribute($value)
    {
        return empty($value) ? null : openssl_decrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function getFullNameAttribute($value)
    {
        return empty($value) ? null : openssl_decrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function getFullNameKanaAttribute($value)
    {
        return empty($value) ? null : openssl_decrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function getMobileTelAttribute($value)
    {
        return empty($value) ? null : openssl_decrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function getFixedTelAttribute($value)
    {
        return empty($value) ? null : openssl_decrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function getEmailAttribute($value)
    {
        return empty($value) ? null : openssl_decrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function getBirthAttribute($value)
    {
        return empty($value) ? null : openssl_decrypt($value, config('app.aes_type'), config('app.aes_key'));
    }

    public function category()
    {
        return $this->hasOne(MedicalChildrenCategory::class, 'id', 'category_id');
    }
}
