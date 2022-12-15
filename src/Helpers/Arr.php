<?php

namespace Hell\Vephar\Helpers;

class Arr
{

    public static function isAssoc(array $array)
    {
        $keys = array_keys($array);

        return array_keys($keys) !== $keys;
    }

}