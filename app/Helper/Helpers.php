<?php

namespace App\Helper;


class Helpers {

    static function replaceNullWithEmptyString($array)
    {
        foreach ($array as $key => $value) 
        {
            if(is_array($value))
                $array[$key] = self::replaceNullWithEmptyString($value);
            else
            {
                if (is_null($value))
                    $array[$key] = '';
            }
        }
        return $array;
    }

}