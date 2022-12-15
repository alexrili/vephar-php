# vephar

**vephar** vephar is a simple library that transform you arrays in collections/resources(objects).

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

### Install

Via Composer

```bash
  composer require alexrili/vephar
```
### Start vephar
Vephar provides you a simple method called `response_to_object` out of the box. 
```php
$yourArray = [];
// simple way, just pass your array data, and vephar will make the magic :)
$response = response_to_object($yourArray);
// passing your own custom contract classes
$response = response_to_object($yourArray, YourCustomContractClass::class);
// passing your own custom contract classes and your custom collection classes  
$response = response_to_object($yourArray, YourCustomContractClass::class, YourCustomContractCollection::class);
```
OR you can call like this
```php
use Hell\Vephar\Response;

$yourArray = [];
$vephar = new Response();
$response = $vephar->make($yourArray);
$response = $vephar->make($yourArray, YourCustomContractClass::class);
$response = $vephar->make($yourArray, YourCustomContractClass::class, YourCustomContractCollection::class);
```

OR by calling static method called toObject
```php
use Hell\Vephar\Response;

$response = Response::toObject($yourArray);
$response = Response::toObject($yourArray, YourCustomContractClass::class);
$response = Response::toObject($yourArray, YourCustomContractClass::class, YourCustomContractCollection::class);
```

### Usage (Automatic way)

The **vephar** will transform your arrays(and the nested as well) in collections of resources automatically. Every index
of your array will be a new attribute of your new collection/resource(object).

```php
use Hell\Vephar\Response;

#can be a response from api request
$array = [
	"title" => "my title",  
	"EMAIL" => "my@email.com",  
	"nested_Array" => [  
		"address" => "street 10",  
		"postal_code" => 1234  
	],  
	"true_array" => [  
		123,  
		10,  
		15  
	]
]
# Instantiating (recommended)
$response = response_to_object($array)
```

```
#Return for collection will be
class Hell\Vephar\Collection#73 (1) {
  protected $items =>
  array(1) {
    [0] =>
    class Hell\Vephar\Resource#71 (4) {
      public $title =>
      string(8) "my title"
      public $email =>
      string(12) "my@email.com"
      public $nestedArray =>
      class Hell\Vephar\Resource#72 (2) {
	    public $address =>
	    string(9) "street 10"
	    public $postalCode =>
	    int(1234)
	  }
      public $trueArray =>
      array(3) {
	    [0] =>
	    int(123)
	    [1] =>
	    int(10)
	    [2] =>
	    int(15)
	  }
    }
  }
}
```

```
#return for a single resource will be
class Hell\Vephar\Resource#74 (4) {
  public $title =>
  string(8) "my title"
  public $email =>
  string(12) "my@email.com"
  public $nestedArray =>
  class Hell\Vephar\Resource#72 (2) {
    public $address =>
    string(9) "street 10"
    public $postalCode =>
    int(1234)
  }
  public $trueArray =>
  array(3) {
    [0] =>
    int(123)
    [1] =>
    int(10)
    [2] =>
    int(15)
  }
}
```

### Usage (Custom way)

The **vephar**  also allows you to assign your own collection and resource contracts to it.
> **Important**:When you use your own contracts you need to explicitly say to if vephar should or not make somthings like going deeper or not into
> your nested arrays or change the pattern of you attribute names to camelCase etc.

```php
namespace Hell\Vephar\Fake;  

use Hell\Vephar\Contracts\CollectionContract; 

class CustomCollection extends CollectionContract  
{  
     // This will tell the vephar to goo deeper or not. 
     // The default is false  means should not go. 
    protected $keepDigging = false;
    
    // This will tell the vephar to change your attributes names to camelCase. 
    // The default is false  means will respect whatever you write
    protected $toCamelCase = false;
    
    // This will tell the vephar that you will set the attributes by your self. 
    // The default is false  means will the vephar will put values automatically
    // intou your attributes if they existes on the input data. 
    protected $setters = false;
}
```

```php
namespace Hell\Vephar\Fake;
  
use Hell\Vephar\Contracts\ResourceContract;  

class CustomResource extends ResourceContract  
{  
	/**  
	* @bool  
	*/  
	protected $setters = true;
	/**  
	* @bool  
	*/  
	protected $keepDigging = true;
	/**  
	* @var  
	*/  
	public $name;  
	
	/**  
	* @var  
	*/  
	public $email;  


	/**  
	* @param mixed $email  
	*/  
	public function setName($name): void  
	{  
		$this->name = $name;  
	}  
	
	/**  
	* @param mixed $email  
	*/  
	public function setEmail($email): void  
	{  
		$this->email = $email;  
	}  
  }
```

```php
#can be a response from api request
$array = [
	"title" => "my title",  
	"EMAIL" => "my@email.com",  
	"nested_Array" => [  
		"address" => "street 10",  
		"postal_code" => 1234  
	],  
	"true_array" => [  
		123,  
		10,  
		15  
	]
]

$vephar = response_to_object($array, CustomResourceClass::class, CustomCollectionClass:class);
```

*In this case the response will be your own custom classes*

```
#Return for collection will be
class Hell\Vephar\CustomCollection#73 (1) {
  protected $items =>
  array(1) {
    [0] =>
    class Hell\Vephar\Resource#71 (4) {
      public $name =>
      null(0) null
      public $email =>
      string(12) "my@email.com"
    }
  }
}
```

```
#return for a single resource will be
class Hell\Vephar\CustomResource#74 (4) {
  public $name =>
  null(0) null
  public $email =>
  string(12) "my@email.com"
}
```

### Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

### Testing

``` bash
$ composer test
```

### Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

### Security

If you discover any security related issues, please email alexrili instead of using the issue tracker.

### Credits

- [Alex Ribeiro][link-author]
- [All Contributors][link-contributors]

### License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/alexrili/vephar.svg?style=flat-square

[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square

[ico-travis]: https://img.shields.io/travis/alexrili/vephar/master.svg?style=flat-square

[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/alexrili/vephar.svg?style=flat-square

[ico-code-quality]: https://img.shields.io/scrutinizer/g/alexrili/vephar.svg?style=flat-square

[ico-downloads]: https://img.shields.io/packagist/dt/alexrili/vephar.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/alexrili/vephar

[link-travis]: https://travis-ci.org/alexrili/vephar

[link-scrutinizer]: https://scrutinizer-ci.com/g/alexrili/vephar/code-structure

[link-code-quality]: https://scrutinizer-ci.com/g/alexrili/vephar

[link-downloads]: https://packagist.org/packages/alexrili/vephar

[link-author]: https://github.com/alexrili

[link-contributors]: ../../contributors
