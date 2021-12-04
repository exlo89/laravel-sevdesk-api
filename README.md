# laravel sevdesk api

[![Latest Version on Packagist](https://img.shields.io/packagist/v/exlo89/laravel-sevdesk-api.svg?style=flat-square)](https://packagist.org/packages/exlo89/laravel-sevdesk-api)
[![Build Status](https://img.shields.io/travis/exlo89/laravel-sevdesk-api/master.svg?style=flat-square)](https://travis-ci.org/exlo89/laravel-sevdesk-api)
[![Quality Score](https://img.shields.io/scrutinizer/g/exlo89/laravel-sevdesk-api.svg?style=flat-square)](https://scrutinizer-ci.com/g/exlo89/laravel-sevdesk-api)
[![Total Downloads](https://img.shields.io/packagist/dt/exlo89/laravel-sevdesk-api.svg?style=flat-square)](https://packagist.org/packages/exlo89/laravel-sevdesk-api)

This package make a connection to the sevdesk api and let you interact with it.

[Sevdesk API Documentation](https://hilfe.sevdesk.de/knowledge/sevdesk-rest-full-api)

## Installation

You can install the package via composer:

```bash
composer require exlo89/laravel-sevdesk-api
```

Set your api token with 
```
SEVDESK_API_TOKEN=xxxxxxxx
```

Optionally you can publish the configfile with:

```bash
php artisan vendor:publish --tag=laravel-sevdesk-api
```

This is the contents of the published config file:

```php
return [
    /*
     * Api token you from sevdesk. 
     */
    'api_token' => env('SEVDESK_API_TOKEN', ''),
];
```

## Instantiation

```php
$sevdeskApi = SevdeskApi::make();
```


### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email exlo89@gmail.com instead of using the issue tracker.

## Credits

- [Martin Appelmann](https://github.com/exlo89)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
