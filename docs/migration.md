# Migration to Version 2.0

As of 2024, Sevdesk uses API version 2.0. The changes mainly affect taxes and the method of tax calculation.
For details, see the official [documentation](https://api.sevdesk.de/#section/sevdesk-Update-2.0).

## Changes in the Package

In version 1.0, you used `TAX_TYPE`, which described the type of tax (e.g., `default`).
With `TAX_RATE`, you could set any tax rate (e.g., `19`).

In version 2.0, however, `TAX_TYPE` is replaced by `TAX_RULE`.

What also needs to be considered is that each `TAX_RULE` is linked to specific tax rates.
For example, with `TAX_RULE` 1 (taxable sales), the `TAX_RATE` can only be 0, 7, or 19.

For the exact mapping, refer to the [official documentation](https://api.sevdesk.de/#section/sevdesk-Update-2.0).

> **_Important:_** `TAX_TYPE` is replaced by `TAX_RULE` in version 2.0.

## Which Version Am I Using?

There are two ways to find out which version you are currently using. Either you check your official Sevdesk account
under your profile, where the version is listed directly under your customer number, or you use the command `php artisan sevdesk:version`.

```shell
php artisan sevdesk:version
```

## Version 1.0 Konfiguration

```dotenv
SEVDESK_TAX_RATE=19
SEVDESK_TAX_TEXT="Vat 19%"
SEVDESK_TAX_TYPE=Standard
SEVDESK_CURRENCY=EUR
SEVDESK_INVOICE_TYPE=RE
```

## Version 2.0 Konfiguration

```dotenv
SEVDESK_TAX_RATE=19
SEVDESK_TAX_TEXT="Vat 19%"
SEVDESK_TAX_RULE=1
SEVDESK_CURRENCY=EUR
```
