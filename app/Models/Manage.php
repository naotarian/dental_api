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
        'name',
        'email',
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
    public function getNameAttribute($value)
    {
        $aes_key = config('app.aes_key');
        $aes_type = config('app.aes_type');
        return empty($value) ? null : openssl_decrypt($value, $aes_type, $aes_key);
    }
    public function getEmailAttribute($value)
    {
        $aes_key = config('app.aes_key');
        $aes_type = config('app.aes_type');
        return empty($value) ? null : openssl_decrypt($value, $aes_type, $aes_key);
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
}
