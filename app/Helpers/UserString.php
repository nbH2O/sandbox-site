<?php 

namespace App\Helpers;

class UserString
{
    static function withBreaks($string, $num = 2){ // 2 is break + a space
        $res = preg_replace('/\n/', '<br/>', preg_replace('/(\s{'.$num.'})\s+/','$1', e($string)));
        return $res;
    }
}