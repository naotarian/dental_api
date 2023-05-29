<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\Admin\VerifyEmail;
use App\Notifications\Admin\ResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Manage extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens;
    use softDeletes;
    use HasUuids;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dental_name',
        'email',
        'tel',
        'last_name',
        'first_name',
        'last_name_kana',
        'first_name_kana',
        'post_number',
        'address1',
        'address2',
        'address3',
        'address4',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * override
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail());
    }
    /**
     * データの取得周り
     */
    public function getDentalNameAttribute($value)
    {
        return empty($value) ? null : openssl_decrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function getEmailAttribute($value)
    {
        return empty($value) ? null : openssl_decrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
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
    public function getTelAttribute($value)
    {
        return empty($value) ? null : openssl_decrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function getAddress1Attribute($value)
    {
        return empty($value) ? null : openssl_decrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function getAddress2Attribute($value)
    {
        return empty($value) ? null : openssl_decrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function getAddress3Attribute($value)
    {
        return empty($value) ? null : openssl_decrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function getAddress4Attribute($value)
    {
        return empty($value) ? null : openssl_decrypt($value, config('app.aes_type'), config('app.aes_key'));
    }
    public function getPostNumberAttribute($value)
    {
        return empty($value) ? null : openssl_decrypt($value, config('app.aes_type'), config('app.aes_key'));
    }


    // /**
    //  * データの保存周り
    //  */
    // Public function setUserAttribute($value){
    //     $aes_key = config('app.aes_key');
    //     $aes_type = config('app.aes_type');
    //     $this->attributes['name'] = empty($value) ? null : openssl_encrypt($value, $aes_type, $aes_key);
    //     $this->attributes['email'] = empty($value) ? null : openssl_encrypt($value, $aes_type, $aes_key);
    //     // $this->attributes['name'] = Crypt::encrypt($value);
    // }
    // public function setEmailAttribute($value)
    // {

    //     $this->attributes['email'] = openssl_encrypt($value, $aes_type, $aes_key);
    // }

    /**
     * override
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
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
    public function staff()
    {
        return $this->hasMany(Staff::class);
    }
}
