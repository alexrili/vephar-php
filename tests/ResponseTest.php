<?php

namespace Hell\Vephar;

use Hell\Vephar\Fake\CustomCollection;
use Hell\Vephar\Fake\CustomResource;
use Hell\Vephar\Fake\CustomResourceCases;
use Hell\Vephar\Fake\CustomResourceWithCustomAttributes;
use Hell\Vephar\Fake\CustomResourceWithoutGoDeeper;
use Hell\Vephar\Fake\FakeApiRequest;

class ResponseTest extends TestCase
{

    /** @test */
    public function shouldReturnInstaceOfResource()
    {
        $dataOne = FakeApiRequest::getOne();
        $resource = Resource::class;
        $this->assertInstanceOf($resource, Response::resource($dataOne));
        $this->assertInstanceOf($resource, Response::collection($dataOne));
        $this->assertInstanceOf($resource, (new Response())->make($dataOne));
    }

    /** @test */
    public function shouldReturnInstanceOfCollection()
    {
        $dataAll = FakeApiRequest::getAll();
        $this->assertInstanceOf(Collection::class, Response::resource($dataAll));
        $this->assertInstanceOf(Collection::class, Response::collection($dataAll));
        $this->assertInstanceOf(Collection::class, (new Response())->make($dataAll));
    }

    /** @test */
    public function shouldReturnTheSameAmountOfData()
    {
        $dataOne = FakeApiRequest::getOne();
        $dataAll = FakeApiRequest::getAll();
        $responseOne = Response::resource($dataOne);
        $responseAll = Response::collection($dataAll);

        $this->assertIsArray($responseOne->toArray());
        $this->assertIsArray($responseAll->toArray());
    }

    /** @test */
    public function shouldReturnInstanceOfCustomResource()
    {
        $dataOne = FakeApiRequest::getOne();
        $customResource = CustomResource::class;
        $this->assertInstanceOf($customResource, Response::resource($dataOne, $customResource));
        $this->assertInstanceOf($customResource, Response::collection($dataOne, $customResource));
        $this->assertInstanceOf($customResource, (new Response($customResource))->make($dataOne));
    }

    /** @test */
    public function shouldReturnInstanceOfCustomCollection()
    {
        $dataAll = FakeApiRequest::getAll();
        $resource = Resource::class;
        $customCollection = CustomCollection::class;
        $this->assertInstanceOf($customCollection, Response::collection($dataAll, $resource, $customCollection));
        $this->assertInstanceOf($customCollection, (new Response($resource, $customCollection))->make($dataAll));
    }

    /** @test */
    public function shouldAcceptObjectAndReturnObject()
    {
        $dataOne = FakeApiRequest::getOne();
        $resource = Response::resource($dataOne);
        $customResource = CustomResource::class;
        $this->assertInstanceOf($customResource, Response::resource($resource, $customResource));
    }

    /** @test */
    public function shouldHaveCustomAttributeSetted()
    {
        $dataOne = FakeApiRequest::getOne();
        $resource = Response::resource($dataOne);
        $customResource = CustomResourceWithCustomAttributes::class;
        $response = Response::resource($resource, $customResource);
        $this->assertNotEmpty($response->myCustomAttribute);
    }

    /** @test */
    public function shouldNotObjectfyNestedArrayWhenNestedIsSetToFalse()
    {
        $data = [
            'first_stage'=>[
                'second_stage'=> 'value'
            ]
        ];
        $resource = Response::resource($data,CustomResourceWithoutGoDeeper::class);

        $this->assertIsArray($resource->firstStage);
        $this->assertEquals($resource->firstStage, $data['first_stage']);
    }

    /** @test */
    public function shouldReturnOriginalArray()
    {
        $data = [
            'firstAttribute'=> 'value'
        ];
        $resource = Response::resource($data,CustomResourceCases::class);
        $this->assertEquals($resource->toArray()['first_attribute'], $data['firstAttribute']);
        $this->assertEquals($resource->toOriginalArray()['firstAttribute'], $data['firstAttribute']);
    }
}
