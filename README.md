
# vephar

**vephar** vephar is a simple library that transform you arrays in collections/resources.

**Note:** vephar uses `illuminate/support` under the hood. If you are using laravel or lumen framework, make sure that you version is  **>= 5.5**  until **6.x**, if you're not using any of this frameworks or this this dependency(illuminate/support) , than you have nothing to worry. 


[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]


## Install

Via Composer

``` bash
$ composer require alexrili/vephar
```

## Usage (Automatic way)
The **vephar** will transform your arrays(and the nested as well) in collections of resources automatically. Every index of your array will be a new attribute of your new collection/resource(object).
``` php
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
$vephar = new Response();
$vephar->make($array);

# Using static methods
// Note: both of these methods check if you are passing a array of collection or a single resource. They will be resolved by themself.
Response::resource($array); 
Response::collection($array);
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
## Usage (Custom way)
The **vephar**  also allows you to assign your own collection and resource contracts to it.


```php
namespace Hell\Vephar\Fake;  

use Hell\Vephar\Contracts\CollectionContract; 

class CustomCollection extends CollectionContract  
{  
}
```
```php
namespace Hell\Vephar\Fake;
  
use Hell\Vephar\Contracts\ResourceContract;  

class CustomResource extends ResourceContract  
{  
	
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
$vephar = new Response(CustomResourceClass::class, CustomCollectionClass:class);
$vephar->make($array);

# Using static methods
// Note: both of these methods check if you are passing a array of collection or a single resource. They will be resolved by themself.
Response::resource($array, CustomResourceClass::class); 
Response::collection($array CustomResourceClass::class, CustomCollection::class);
```
*In this case the response will be your  own custom classes*
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

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email alexrili instead of using the issue tracker.

## Credits

- [Alex Ribeiro][link-author]
- [All Contributors][link-contributors]

## License

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
