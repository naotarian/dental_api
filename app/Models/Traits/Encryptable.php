<?php

namespace App\Models\Traits;

use Illuminate\Support\FacadesCrypt;

trait Encryptable
{
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if (in_array($key, $this->encryptable, true)) {
            $aes_key = config('app.aes_key');
            $aes_type = config('app.aes_type');
            $value = !empty($value) ? openssl_decrypt($value, $aes_type, $aes_key) : null;
            return $value;
        }
        return $value;
    }

    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encryptable, true)) {
            $aes_key = config('app.aes_key');
            $aes_type = config('app.aes_type');
            $value = !empty($value) ? openssl_encrypt($value, $aes_type, $aes_key) : null;
        }
        return parent::setAttribute($key, $value);
    }
}
