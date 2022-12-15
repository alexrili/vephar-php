<?php

namespace Hell\Vephar\Helpers;

class Str
{
    /**
     * @param $str
     * @return string
     */
    public static function toCamelCase($str)
    {
        $str = ctype_upper($str) ? strtolower($str) : $str;
        $str = preg_replace_callback('/_([a-z])/', function ($letter) {
            return strtoupper($letter[1]);
        }, $str);
        return lcfirst(str_replace("_", "", $str));
    }

    /**
     * @param $input
     * @return string
     */
    public static function toSnakeCase($input)
    {

        if (preg_match('/[A-Z]/', $input) === 0) {
            return $input;
        }
        $pattern = '/([a-z])([A-Z])/';
        return  strtolower(preg_replace_callback($pattern, function ($a) {
            return $a[1] . "_" . strtolower($a[2]);
        }, $input));
    }
}