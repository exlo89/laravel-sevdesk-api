# laravel sevdesk api

[![Latest Version on Packagist](https://img.shields.io/packagist/v/exlo89/laravel-sevdesk-api.svg?style=flat-square)](https://packagist.org/packages/exlo89/laravel-sevdesk-api)
[![Total Downloads](https://img.shields.io/packagist/dt/exlo89/laravel-sevdesk-api.svg?style=flat-square)](https://packagist.org/packages/exlo89/laravel-sevdesk-api)
[![Test](https://github.com/exlo89/laravel-sevdesk-api/actions/workflows/testing.yml/badge.svg?branch=main)](https://github.com/exlo89/laravel-sevdesk-api/actions/workflows/testing.yml)

This package make a connection to the sevdesk api and let you interact with it.

[Sevdesk API Documentation](https://hilfe.sevdesk.de/knowledge/sevdesk-rest-full-api)

## Documentation

- [Official Package Documentation](https://exlo89.github.io/laravel-sevdesk-api).

## Installation

You can install the package via composer:

```bash
composer require exlo89/laravel-sevdesk-api
```

Set your api token with

```
SEVDESK_API_TOKEN=xxxxxxxx
```

Optionally you can publish the config file with:

```bash
php artisan vendor:publish --provider="Exlo89\LaravelSevdeskApi\SevdeskApiServiceProvider" --tag="config"
```

## Usage

First Instantiate a sevdesk instance and then fetch all the data.

```php
$sevdeskApi = SevdeskApi::make();
$sevdeskApi->invoice()->allDraft();
```


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email
[hello@martin-appelmann.de](mailto:hello@martin-appelmann.de?subject=Laravel%20Sevdesk%20Issue)
instead of using the issue tracker.

## Credits

- [Martin Appelmann](https://github.com/exlo89)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
