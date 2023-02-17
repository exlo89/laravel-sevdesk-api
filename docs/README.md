# laravel sevdesk api

[![Latest Version on Packagist](https://img.shields.io/packagist/v/exlo89/laravel-sevdesk-api.svg?style=flat-square)](https://packagist.org/packages/exlo89/laravel-sevdesk-api)
[![Total Downloads](https://img.shields.io/packagist/dt/exlo89/laravel-sevdesk-api.svg?style=flat-square)](https://packagist.org/packages/exlo89/laravel-sevdesk-api)
[![Test](https://github.com/exlo89/laravel-sevdesk-api/actions/workflows/testing.yml/badge.svg?branch=main)](https://github.com/exlo89/laravel-sevdesk-api/actions/workflows/testing.yml)

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

Optionally you can publish the config file with:

```bash
php artisan vendor:publish --provider="Exlo89\LaravelSevdeskApi\SevdeskApiServiceProvider" --tag="config"
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

## Usage

First Instantiate a sevdesk instance.

```php
$sevdeskApi = SevdeskApi::make();
```

### Create Contact Address

```php
$sevdeskApi->contactAddress()->create($contactId, $parameters);
```

### Create Communication Way

Create phone number.

```php
$sevdeskApi->communicationWay()->createPhone($contactId, $phoneNumber);
```

Create email.

```php
$sevdeskApi->communicationWay()->createEmail($contactId, $email);
```

Create website.

```php
$sevdeskApi->communicationWay()->createWebsite($contactId, $website);
```

### Retrieve Communication Way

Retrieve all communication ways.

```php
$sevdeskApi->communicationWay()->all();
```

Retrieve communication ways of a specific contact.

```php
$sevdeskApi->communicationWay()->get($contactId);
```

### Delete Communication Way

To delete a single communication way.

```php
$sevdeskApi->communicationWay()->delete($communicationWayId);
```

### Retrieve Country

To retrieve all countries use:

```php
$sevdeskApi->staticCountry()->all();
```

To retrieve a single country use:

```php
$sevdeskApi->staticCountry()->get($countryId);
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
