<?php


namespace Hell\Vephar\Contracts;

use Hell\Vephar\Response;

abstract class ResourceContract
{

    /**
     * ResourceContract constructor.
     * @param array $data
     * @param bool $setters
     * @throws \Throwable
     */
    public function __construct($data, $setters = true)
    {
        if ($setters) {
            $this->bySetMethod($data);
            return;
        }
        $this->byDinamicallyAttribute($data);
        return;
    }

    /**
     * @param $data
     */
    protected function bySetMethod($data)
    {
        $setMethods = preg_grep("/^set/", get_class_methods($this));
        foreach ($setMethods as $method) {
            $this->{$method}($this->toObject($data));
        }
    }


    /**
     * @param $data
     * @throws \Throwable
     */
    protected function byDinamicallyAttribute($data)
    {
        foreach ($data as $attribute => $value) {
            $attributeName = toCamelCase($attribute);
            $this->{$attributeName} = $this->getValue($value);
        }
    }

    protected function toObject($data)
    {
        if (is_object($data)) {
            return $data;
        }

        $object = clone $this;
        foreach ($data as $attribute => $value) {
            $attributeName = toCamelCase($attribute);
            $object->{$attributeName} = $value;
        }
        return $object;
    }


    /**
     * @param $value
     * @return mixed
     * @throws \Throwable
     */
    protected function getValue($value)
    {
        if (!is_array($value) || !is_object_array($value)) {
            return $value;
        }
        return Response::resource($value);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
