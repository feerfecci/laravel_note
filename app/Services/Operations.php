<?php

namespace App\Services;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class Operations{
    public static function decrypt($value){
        try {
            $value = Crypt::decrypt($value);
        } catch (DecryptException $de) {
            return redirect()->route('home');
        }

        return $value;
    }
}