# Erste Schritte

## Installation

Installiere das Package über [composer](https://getcomposer.org/):

```shell
composer require exlo89/laravel-sevdesk-api
```

Um die API von Sevdesk zu nutzen, benötigst du einen API-Schlüssel. Diesen findest du auf deiner Sevdesk-Plattform
unter ["Einstellungen" > "Benutzer"](https://my.sevdesk.de/#/admin/userManagement). Wähle den Admin Benutzer aus und
ganz unten im "API-Token" Bereich, erhälst du den Schlüssel.

Diesen Schlüssel fügst du in deiner `.env` Datei mit ein.

```dotenv
SEVDESK_API_TOKEN=xxxxxxxx
```

## Anwendung

Erstelle mit Hilfe von `SevdeskApi::make()` eine neue Sevdesk Instanz.

```php
$sevdeskApi = SevdeskApi::make();
```

## Konfiguration

Führe folgenden Befehl aus um die Konfigurationsdatei zu bearbeiten.

```shell
php artisan vendor:publish --provider="Exlo89\LaravelSevdeskApi\SevdeskApiServiceProvider" --tag="config"
```

Nach der Ausführung findest du die Datei in dem `config` Ordner in deinem Laravel Projekt.

```php
return [
    /**
     * Your Sevdesk api token. You can find it on your Sevdesk platform under ["Settings" > "Users"]
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

Die `sev_user_id` wird zum erstellen von Rechnungen benötigt. Das ist die Ansprechperson für die Rechnungen. Um alle
Nutzer mit ihren IDs anzuzeigen führe folgenden Artisan Command aus.

```shell
php artisan sevdesk:user
```

Du bekommst eine Liste aller Anwender von Sevdesk. Wähle hier dein Anwender aus und kopiere dir die ID in die .env
Datei.

```dotenv
SEVDESK_SEV_USER=xxxxx
```
