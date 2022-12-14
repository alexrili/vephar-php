<?php


namespace Hell\Vephar\Contracts;

use Hell\Vephar\Response;

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
    public $goDeeper = true;

    /**
     * ResourceContract constructor.
     * @param $data
     * @param bool $setters
     */
    public function __construct($data, $setters = true)
    {
        if ($setters) {
            $this->bySetMethod($data);
            return;
        }
        $this->byDinamicallyAttribute($data);
    }

    /**
     * @param $data
     * @return ResourceContract
     */
    public function bySetMethod($data)
    {
        $data = $this->arrayIndexToCamelCase($data);
        $object = $this;
        $methods = get_class_methods($object);
        foreach ($methods as $method) {
            preg_match(' /^(set)(.*?)$/i', $method, $results);
            $setMethod = $results[1] ?? '';
            $attributeName = toCamelCase($results[2] ?? '');
            if ($setMethod == 'set' && array_key_exists($attributeName, $data)) {
                $object->$method($this->getValue($data[$attributeName]));
            }
        }

        if (method_exists($object, "setCustomAttributes")) {
            $object->setCustomAttributes(new $this($data, false));
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
            $attributeName = toCamelCase($attribute);
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
        if (!$this->goDeeper || !is_array($value) || !is_object_array($value)) {
            return $value;
        }
        return Response::resource($value);
    }

    /**
     * @param $data
     */
    protected function byDinamicallyAttribute($data)
    {
        foreach ($data as $attribute => $value) {
            $attributeName = toCamelCase($attribute);
            $this->{$attributeName} = $this->getValue($value);
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $attributes = get_object_vars($this);
        $newAttributes = [];
        foreach ($attributes as $key => $value) {
            $newAttributes[toSnakeCase($key)] = $value;
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
