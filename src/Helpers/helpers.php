<?php

use Hell\Vephar\Collection;
use Hell\Vephar\Resource;
use Hell\Vephar\Response;

if (!function_exists("response_to_object")) {
    /**
     * @param $data
     * @param string $resource
     * @param string $collection
     * @return mixed
     */
    function response_to_object(
        $data = [],
        string $resource = Resource::class,
        string $collection = Collection::class
    ) {
        return Response::toObject($data, $resource, $collection);
    }
}