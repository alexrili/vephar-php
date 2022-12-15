<?php

namespace Hell\Vephar\Helpers;

/**
 * @author '@alexrili'
 * @class Arr
 * @package Hell\Vephar\Helpers
 */
class Arr
{

    /**
     * @param array $array
     * @return bool
     */
    public static function isAssoc(array $array)
    {
        $keys = array_keys($array);

        return array_keys($keys) !== $keys;
    }

}