<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory;
    use softDeletes;

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

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }
}
