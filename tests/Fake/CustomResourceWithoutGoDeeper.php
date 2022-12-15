<?php


namespace Hell\Vephar\Fake;

use Hell\Vephar\Resource;


/**
 * @author '@alexrili'
 * @class CustomResourceWithoutGoDeeper
 * @package Hell\Vephar\Fake
 */
class CustomResourceWithoutGoDeeper extends Resource
{
    /**
     * @var
     */
    public $firstStage;
    protected $setters = true;


    /**
     * @param mixed $firstStage
     */
    public function setFirstStage($firstStage): void
    {
        $this->firstStage = $firstStage;
    }
}
