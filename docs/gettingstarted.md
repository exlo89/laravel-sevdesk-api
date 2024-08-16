# First steps

## Installation

Install the package via [composer](https://getcomposer.org/):

```shell
composer require exlo89/laravel-sevdesk-api
```

To use the Sevdesk API you need an API key. You can find it on your Sevdesk platform
under ["Extensions" > "API"](https://my.sevdesk.de/admin/api) or ["Settings" > "Users"](https://my.sevdesk.de/#/admin/userManagement). Select the admin user and
at the bottom of the "API-Token" section, you will get the key.

Add this key to your `.env` file.

```dotenv
SEVDESK_API_TOKEN=xxxxxxxx
```

## Application

Create a new Sevdesk instance using `SevdeskApi::make()`.

```php
$sevdeskApi = SevdeskApi::make();
```

## Configuration

Execute the following command to edit the configuration file.

```shell
php artisan vendor:publish --provider="Exlo89\LaravelSevdeskApi\SevdeskApiServiceProvider" --tag="config"
```

After execution you will find the file in the `config` folder in your Laravel project.

```php
return [
/**
* Your Sevdesk api token. You can find it on your Sevdesk platform under ["Settings" > "Users"].
*/
'api_token' => env('SEVDESK_API_TOKEN', ''),

    /**
     * Sev User (contact person) is necessary to create invoices.
     */
    'sev_user_id' => env('SEVDESK_SEV_USER', ''),

    /**
     * These are also necessary configs to create invoices or orders.
     */
    'tax_rate'     => env('SEVDESK_TAX_RATE', 19),
    'tax_text'     => env('SEVDESK_TAX_TEXT', 'VAT 19%'),   // only in version 1.0
    'tax_type'     => env('SEVDESK_TAX_TYPE', 'default'),   // only in version 1.0
    'tax_rule'     => env('SEVDESK_TAX_RULE', 1),           // only in version 2.0
    'currency'     => env('SEVDESK_CURRENCY', 'EUR'),
    'invoice_type' => env('SEVDESK_INVOICE_TYPE', 'RE'),
];
```

The `sev_user_id` is needed to create invoices or orders. This is the contact person for the invoices and orders. To display all
users with their IDs execute the following Artisan command.

```shell
php artisan sevdesk:user
```

You will get a list of all users of Sevdesk. Select your user and copy the ID into the .env file.
file.

```dotenv
SEVDESK_SEV_USER=xxxxx
```
