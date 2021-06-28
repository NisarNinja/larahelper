# Useful helpers for every laravel project

[![Latest Version on Packagist](https://img.shields.io/packagist/v/easoblue/larahelper.svg?style=flat-square)](https://packagist.org/packages/easoblue/larahelper)
[![Build Status](https://img.shields.io/travis/easoblue/larahelper/master.svg?style=flat-square)](https://travis-ci.org/easoblue/larahelper)
[![Quality Score](https://img.shields.io/scrutinizer/g/easoblue/larahelper.svg?style=flat-square)](https://scrutinizer-ci.com/g/easoblue/larahelper)
[![Total Downloads](https://img.shields.io/packagist/dt/easoblue/larahelper.svg?style=flat-square)](https://packagist.org/packages/easoblue/larahelper)


## Installation

You can install the package via composer:

```bash
composer require easoblue/larahelper
```

## Usage

You can add alias for shorthand or import LaraHelper facade directly.

``` php
use Easoblue\LaraHelper\Facade\LaraHelper;
```

Once ready you can use generateString method to generate random or unique string. You can pass paramter to generate specific type of string.

``` php
LaraHelper::generateString('alpha');
```
You can use checkUnique and chain with generateString, table name and column name will be required to validate the unique string.

``` php
LaraHelper::checkUnique('users','username')->generateString('alpha');
```

``` php
LaraHelper::checkUnique('users','username')->generateString('alpha');

LaraHelper::checkUnique('users','username')->prefix('u_')->postfix('u_')->generateString('alpha');
// prefix will be prepended to the generated string before checking unique.
Same as postfix will be appended to the generated string before checking unique.


// This method will format the error response and return the object with single validation error instead of array.

// $validator is the intance of Illuminate\Validation\Validator class;
if($validator->fails()){
 return LaraHelper::formatValidatorError($validator);
}

LaraHelper::formatToCamelCase('format to camel case');
```

### Testing

to be added.


## Complete documentation

Complete documentation will be available at doc.easoblue.com

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email issues@easoblue.com instead of using the issue tracker.

## Credits

- [Nisar Ahmed](https://github.com/easoblue)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
