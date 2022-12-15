<?php

namespace Hell\Vephar;

use Hell\Vephar\Contracts\ResourceContract;


/**
 * @author '@alexrili'
 * @class Resource
 * @package Hell\Vephar
 */
class Resource extends ResourceContract
{
    /**
     * @param $data
     */
    public function __construct($data)
    {
        parent::__construct($data);
    }
}
