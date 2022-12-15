<?php


namespace Hell\Vephar\Contracts;

abstract class CollectionContract
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function toArray()
    {
        return (array)$this->data;
    }
}
