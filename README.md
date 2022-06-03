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

### Create Contact

Create sevdesk contacts. There are 4 different default contact types in sevdesk.

- supplier
- customer
- partner
- prospect customer

The optional `$parameters` is for additional information like description, vatNumber or bankNumber.

```php
$sevdeskApi->contact()->createSupplier('Supplier Organisation', $parameters);
$sevdeskApi->contact()->createCustomer('Customer Organisation', $parameters);
$sevdeskApi->contact()->createPartner('Partner Organisation', $parameters);
$sevdeskApi->contact()->createProspectCustomer('Prospect Customer Organisation', $parameters);
```

For accounting contact you have to create a contact first. You create a accounting contact using the created contact id.

```php
$sevdeskApi->contact()->createAccountingContact($contactId);
```

For custom contact types use your custom category id.

```php
$sevdeskApi->contact()->createCustom('Custom Organisation', $categoryId, $parameters);
```

Check [Create Contact](https://my.sevdesk.de/api/ContactAPI/doc.html#operation/createContact) for more information.

### Retrieve Contact

To get all contacts.

```php
$sevdeskApi->contact()->all();
$sevdeskApi->contact()->allSupplier();
$sevdeskApi->contact()->allCustomer();
$sevdeskApi->contact()->allPartner();
$sevdeskApi->contact()->allProspectCustomer();
```

To get all contacts from a custom type.

```php
$sevdeskApi->contact()->allCustom($categoryId);
```

To get a single contact.

```php
$sevdeskApi->contact()->get($contactId);
```

### Update Contact

To update a single contact. `$contactId` is required.

```php
$sevdeskApi->contact()->update($contactId, $parameters);
```

### Delete Contact

To delete a single contact. `$contactId` is required.

```php
$sevdeskApi->contact()->delete($contactId);
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

### Retrieve Invoice

To get all invoices.

```php
$sevdeskApi->invoice()->all();
```

To get all invoices filtered by status `draft`, `open` or `payed`.

```php
$sevdeskApi->invoice()->allDraft();
$sevdeskApi->invoice()->allOpen();
$sevdeskApi->invoice()->allPayed();
```

To get all invoices filtered by a giving `$contactId`.

```php
$sevdeskApi->invoice()->allByContact($contactId);
```

To get all invoices filtered by giving `$timestamp`.

```php
$sevdeskApi->invoice()->allAfter($timestamp);
$sevdeskApi->invoice()->allBefore($timestamp);
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
