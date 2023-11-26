# Laravel Sevdesk API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/exlo89/laravel-sevdesk-api.svg?style=flat-square)](https://packagist.org/packages/exlo89/laravel-sevdesk-api)
[![Total Downloads](https://img.shields.io/packagist/dt/exlo89/laravel-sevdesk-api.svg?style=flat-square)](https://packagist.org/packages/exlo89/laravel-sevdesk-api)
[![Test](https://github.com/exlo89/laravel-sevdesk-api/actions/workflows/testing.yml/badge.svg?branch=main)](https://github.com/exlo89/laravel-sevdesk-api/actions/workflows/testing.yml)

Dieses Package stellt eine Verbindung zur Sevdesk-API her und lässt dich damit interagieren.

## Installation

Das Package kannst du via composer istallieren:

```bash
composer require exlo89/laravel-sevdesk-api
```

Setze dein API token in der .env Datei.

```
SEVDESK_API_TOKEN=xxxxxxxx
```

Optional kannst du dir auch die configs Datei kopieren lassen:

```bash
php artisan vendor:publish --provider="Exlo89\LaravelSevdeskApi\SevdeskApiServiceProvider" --tag="config"
```

## Usage

Zuerst benötigst du eine SevdeskApi Instance.

```php
$sevdeskApi = SevdeskApi::make();
$sevdeskApi->invoice()->allDraft();
```
