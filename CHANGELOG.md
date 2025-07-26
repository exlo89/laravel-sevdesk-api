# Changelog

All notable changes to `laravel-sevdesk-api` will be documented in this file

## 1.0.3 - 2025-07-26
- add send by support for invoice
- update documentation

## 1.0.2 - 2024-03-18
- add pagination support for invoice list methods
- update documentation

## 1.0.1 - 2025-03-04
- changed authorization from parameter to header ([more infos](https://tech.sevdesk.com/api_news/posts/2025_02_06-authentication-method-removed/))
- fix code style

## 1.0.0 - 2024-08-16
- add order resource to package
- fix bug in invoice download
- add new command to retrieve sevdesk version
- update documentation

## 0.1.13 - 2024-06-02

- update readme and docs

## 0.1.12 - 2024-05-30

- bug fixing in `allByPaymentMethod()`

## 0.1.11 - 2024-05-17

- add `allByPaymentMethod()` to invoice
- update documentation

## 0.1.10 - 2024-04-02

- add `getSequence()` to credit note
- add `getSequence()` to invoice
- update documentation
- remove automatic generated invoice number and credit note number
- `createReminder()` return now as SevInvoice

## 0.1.9 - 2024-03-13

- add `createReminder()` to invoice
- update documentation

## 0.1.8 - 2024-02-21

- add `allDue()` to invoice
- update documentation

## 0.1.7 - 2024-02-03

- fix small bug
- add `allBetween()` to invoice
- implemented credit note api
- update documentation

## 0.1.6 - 2024-01-09

- fix typos in documentation
- fix small bug
- add `priceTax`, `priceGross`, `positionNumber` and `discount` to invoice

## 1.0.0 - 2021-12-05

- initial release
- implemented basic api handler
- implemented sevdesk contact api
