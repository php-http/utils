> Moved to php-http/client-common

# HTTP Client utilities

[![Latest Version](https://img.shields.io/github/release/php-http/utils.svg?style=flat-square)](https://github.com/php-http/utils/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/php-http/utils.svg?style=flat-square)](https://travis-ci.org/php-http/utils)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/php-http/utils.svg?style=flat-square)](https://scrutinizer-ci.com/g/php-http/utils)
[![Quality Score](https://img.shields.io/scrutinizer/g/php-http/utils.svg?style=flat-square)](https://scrutinizer-ci.com/g/php-http/utils)
[![Total Downloads](https://img.shields.io/packagist/dt/php-http/utils.svg?style=flat-square)](https://packagist.org/packages/php-http/utils)

**HTTP Client utilities.**


## Install

Via Composer

``` bash
$ composer require php-http/utils
```


## Contents

The utilities are useful classes for users of HTTPlug and the `php-http/message-factory` library.

* `HttpMethodsClient` - Client decorator that provides convenience methods for HTTP requests without the need of acquiring a PSR-7 RequestInterface;
* `BatchClient` - Client decorator to send a list of requests in one call;
* Factory implementations for Guzzle6 and Diactoros.


## Documentation

Please see the [official documentation](http://docs.httplug.io).


## Testing

``` bash
$ composer test
```


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.


## Security

If you discover any security related issues, please contact us at [security@httplug.io](mailto:security@httplug.io)
or [security@php-http.org](mailto:security@php-http.org).


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
