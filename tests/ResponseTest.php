<?php

namespace Hell\Vephar;

use Hell\Vephar\Fake\CustomCollection;
use Hell\Vephar\Fake\CustomResource;
use Hell\Vephar\Fake\CustomResourceCases;
use Hell\Vephar\Fake\CustomResourceWithCustomAttributes;
use Hell\Vephar\Fake\CustomResourceWithKeepdigging;
use Hell\Vephar\Fake\FakeApiRequest;

class ResponseTest extends TestCase
{

    /** @test */
    public function shouldReturnInstaceOfResource()
    {
        $dataOne = FakeApiRequest::getOne();
        $resource = Resource::class;
        $this->assertInstanceOf($resource, response_to_object($dataOne));
        $this->assertInstanceOf($resource, response_to_object($dataOne));
        $this->assertInstanceOf($resource, (new Response())->make($dataOne));
    }

    /** @test */
    public function shouldReturnInstanceOfCollection()
    {
        $dataAll = FakeApiRequest::getAll();
        $this->assertInstanceOf(Collection::class, response_to_object($dataAll));
        $this->assertInstanceOf(Collection::class, response_to_object($dataAll));
        $this->assertInstanceOf(Collection::class, (new Response())->make($dataAll));
    }

    /** @test */
    public function shouldReturnTheSameAmountOfData()
    {
        $dataOne = FakeApiRequest::getOne();
        $dataAll = FakeApiRequest::getAll();
        $responseOne = response_to_object($dataOne);
        $responseAll = response_to_object($dataAll);

        $this->assertIsArray($responseOne->toArray());
        $this->assertIsArray($responseAll->toArray());
    }

    /** @test */
    public function shouldReturnInstanceOfCustomResource()
    {
        $dataOne = FakeApiRequest::getOne();
        $customResource = CustomResource::class;
        $this->assertInstanceOf($customResource, response_to_object($dataOne, $customResource));
        $this->assertInstanceOf($customResource, response_to_object($dataOne, $customResource));
        $this->assertInstanceOf($customResource, (new Response($customResource))->make($dataOne));
    }

    /** @test */
    public function shouldReturnInstanceOfCustomCollection()
    {
        $dataAll = FakeApiRequest::getAll();
        $resource = Resource::class;
        $customCollection = CustomCollection::class;
        $this->assertInstanceOf($customCollection, response_to_object($dataAll, $resource, $customCollection));
        $this->assertInstanceOf($customCollection, (new Response($resource, $customCollection))->make($dataAll));
    }

    /** @test */
    public function shouldAcceptObjectAndReturnObject()
    {
        $dataOne = FakeApiRequest::getOne();
        $resource = response_to_object($dataOne);
        $customResource = CustomResource::class;
        $this->assertInstanceOf($customResource, response_to_object($resource, $customResource));
    }

    /** @test */
    public function shouldHaveCustomAttributeSetted()
    {
        $dataOne = FakeApiRequest::getOne();
        $resource = response_to_object($dataOne);
        $customResource = CustomResourceWithCustomAttributes::class;
        $response = response_to_object($resource, $customResource);
        $this->assertNotEmpty($response->getMyCustomAttribute());
    }

    /** @test */
    public function shouldObjectfyNestedArrayWhenKeepdigginIsSetToTrue()
    {
        $data = [
            'attribute'=>[
                'second_stage'=> 'value'
            ],
            'snake_to_camel'=> 'snakeToCamel'
        ];
        $resource = response_to_object($data,CustomResourceWithKeepdigging::class);
        $this->assertInstanceOf(Resource::class, $resource->attribute);
        $this->assertEquals($resource->snakeToCamel, $data['snake_to_camel']);
    }

    /** @test */
    public function shouldReturnOriginalArray()
    {
        $data = [
            'firstAttribute'=> 'value'
        ];
        $resource = response_to_object($data,CustomResourceCases::class);
        $this->assertEquals($resource->toArray()['first_attribute'], $data['firstAttribute']);
        $this->assertEquals($resource->toOriginalArray()['firstAttribute'], $data['firstAttribute']);
    }
}
