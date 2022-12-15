<?php


namespace Hell\Vephar\Fake;

use Hell\Vephar\Resource;


/**
 * @author '@alexrili'
 * @class CustomResourceWithKeepdigging
 * @package Hell\Vephar\Fake
 */
class CustomResourceWithKeepdigging extends Resource
{

//    protected $setters = true;
    public $keepDigging = true;
    public $toCamelCase = true;


    public $attribute;
    public $snake_to_camel;

}
