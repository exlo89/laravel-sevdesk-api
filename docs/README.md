# Laravel Sevdesk API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/exlo89/laravel-sevdesk-api.svg?style=flat-square)](https://packagist.org/packages/exlo89/laravel-sevdesk-api)
[![Total Downloads](https://img.shields.io/packagist/dt/exlo89/laravel-sevdesk-api.svg?style=flat-square)](https://packagist.org/packages/exlo89/laravel-sevdesk-api)
[![Test](https://github.com/exlo89/laravel-sevdesk-api/actions/workflows/testing.yml/badge.svg?branch=main)](https://github.com/exlo89/laravel-sevdesk-api/actions/workflows/testing.yml)

This package make a connection to the sevdesk api and let you interact with it.

## Installation

You can install the package via composer:

```bash
composer require exlo89/laravel-sevdesk-api
```

Set your api token with

```dotenv
SEVDESK_API_TOKEN=xxxxxxxx
```

Optionally you can publish the config file with:

```bash
php artisan vendor:publish --provider="Exlo89\LaravelSevdeskApi\SevdeskApiServiceProvider" --tag="config"
```

## Usage

First Instantiate a sevdesk instance.

```php
$sevdeskApi = SevdeskApi::make();
$sevdeskApi->invoice()->allDraft();
```
