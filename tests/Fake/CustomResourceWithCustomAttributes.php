<?php


namespace Hell\Vephar\Fake;

use Hell\Vephar\Contracts\ResourceContract;

/**
 * Class CustomResource
 * @packaddress Hell\Vephar\Fake
 */
class CustomResourceWithCustomAttributes extends ResourceContract
{

    /**
     * @var
     */
    public $name;
    /**
     * @var
     */
    public $address;

    /**
     * @var
     */
    public $anotherArray;

    /**
     * @var
     */
    public $trueArray;

    /**
     * @var
     */
    public $lastName;

    /**
     * @var
     */
    public $myCustomAttribute;

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }

    /**
     * @param mixed $anotherArray
     */
    public function setAnotherArray($anotherArray): void
    {
        $this->anotherArray = $anotherArray;
    }

    /**
     * @param mixed $trueArray
     */
    public function setTrueArray($trueArray): void
    {
        $this->trueArray = $trueArray;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }


    /**
     * @return string
     */
    public function getMyCustomAttribute()
    {
        return $this->lastName . ' ' . $this->name;
    }


}
