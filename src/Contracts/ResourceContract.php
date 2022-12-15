<?php


namespace Hell\Vephar\Contracts;

use Hell\Vephar\Helpers\Str;
use Hell\Vephar\Resource;


/**
 * @author '@alexrili'
 * @class ResourceContract
 * @package Hell\Vephar\Contracts
 */
abstract class ResourceContract
{
    /**
     * @var bool
     */
    protected $keepDigging = false;
    /**
     * @var bool
     */
    protected $toCamelCase = false;
    /**
     * @var bool
     */
    protected $setters = false;

    /**
     * ResourceContract constructor.
     * @param $data
     */
    public function __construct($data)
    {
        if ($this->setters) {
            $this->bySetMethod($data);
            return;
        }

        $this->byDinamicallyAttribute($data);
    }

    /**
     * @param $data
     * @return \Hell\Vephar\Contracts\ResourceContract
     */
    public function bySetMethod($data)
    {
        $data = $this->arrayIndexToCamelCase($data);
        $object = $this;
        $methods = get_class_methods($object);
        foreach ($methods as $method) {
            $isSetMethod = preg_match(SET_METHOD_PATTERN, $method, $results);
            if ($isSetMethod) {
                $methodName = $results[0];
                $attributeName = Str::toCamelCase($results[1]);
                $object->$methodName($this->getValue($data[$attributeName] ?? null));
            }
        }

        return $object;
    }

    /**
     * @param $data
     * @return array
     */
    protected function arrayIndexToCamelCase($data = [])
    {
        $newData = [];
        foreach ($data as $attribute => $value) {
            $attributeName = Str::toCamelCase($attribute);
            $newData[$attributeName] = $value;
        }
        return $newData;
    }

    /**
     * @param $value
     * @return mixed
     */
    protected function getValue($value)
    {
        if (!$this->keepDigging || !is_array($value)) {
            return $value;
        }
        return response_to_object($value);
    }

    /**
     * @param $data
     */
    protected function byDinamicallyAttribute($data)
    {
        $object = $this;
        $child = get_class($object);
        if ($child === Resource::class) {
            foreach ($data as $attribute => $value) {
                $attributeName = Str::toCamelCase($attribute);
                $this->{$attributeName} = $this->getValue($value);
            }
            return;
        }

        $attributes = get_class_vars($child);
        foreach ($attributes as $attribute => $value) {
            if (!$this->isReservedVar($attribute)) {
                $attributeName = $this->getAttributeName($attribute);
                $this->{$attributeName} = $this->getValue($data[$attribute] ?? $value);
            }
        }
    }

    /**
     * @param $attribute
     * @return false|int
     */
    protected function isReservedVar($attribute)
    {
        return preg_match("/" . $attribute . "/", RESERVED_VARS);
    }

    /**
     * @param $attributeName
     * @return mixed|string
     */
    protected function getAttributeName($attributeName)
    {
        return $this->toCamelCase ? Str::toCamelCase($attributeName) : $attributeName;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $attributes = get_object_vars($this);
        $newAttributes = [];
        foreach ($attributes as $key => $value) {
            $newAttributes[Str::toSnakeCase($key)] = $value;
        }
        return $newAttributes;
    }

    /**
     * @return array
     */
    public function toOriginalArray(): array
    {
        return json_decode(json_encode(get_object_vars($this)), true);
    }
}
