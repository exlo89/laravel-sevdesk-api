# Angebot

Ähnlich wie bei [Rechnung](invoice.md): Wenn du Angebote erstellen möchtest, musst du einige Konfigurationen in
deiner `.env` Datei vornehmen.

```dotenv
SEVDESK_TAX_RATE=19
SEVDESK_TAX_TEXT="MwSt 19%"
SEVDESK_TAX_TYPE=default
SEVDESK_TAX_RULE=1
SEVDESK_CURRENCY=EUR
```

> **_Version 2.0:_** Du benötigst `SEVDESK_TAX_RULE` für API-Version 2.0.

Der Standard Angebotstyp ist `AN`, aber du kannst zwischen 3 verschiedenen Angebotstypen wählen:

- [AN] Ein normales Angebot, das eine einfache Schätzung für einen Endkunden dokumentiert.
- [AB] Eine Bestätigung für ein Angebot.
- [LI] Eine Bestätigung, dass Waren aus einem Angebot versandt wurden.

Es gibt eine OrderType Klasse im Package. Du kannst sie wie folgt verwenden:

```php
use Exlo89\LaravelSevdeskApi\Constants\OrderType;   // importiere die Klasse

$sevdeskApi->order()->all(OrderType::PROPOSAL);     // verwenden z.B. um nach Angebotstyp zu filtern
```

Für weitere Details zu den Angebotstypen klicke [hier](https://api.sevdesk.de/#tag/Order/Types-and-status-of-orders).

## Angebote abrufen

Um alle Angebote abzurufen, rufe die `all()` Funktion auf.

```php
$sevdeskApi->order()->all();
```

Um die Angebote nach Status zu filtern, verwende eine dieser Funktionen.
Alle diese Funktionen haben einen optionalen Parameter `$orderType`, um nach Angebotstyp zu filtern.
[Hier](https://api.sevdesk.de/#tag/Order/Types-and-status-of-orders) ist ein Überblick über die möglichen Status und
Typen.

```php
$sevdeskApi->order()->allDraft();
$sevdeskApi->order()->allDelivered();
$sevdeskApi->order()->allCancelled();
$sevdeskApi->order()->allAccepted();
$sevdeskApi->order()->allPartialCalculated();
$sevdeskApi->order()->allCalculated();

// mit Angebotstyp
$sevdeskApi->order()->all(\Exlo89\LaravelSevdeskApi\Constants\OrderType::PROPOSAL);
$sevdeskApi->order()->allCancelled(\Exlo89\LaravelSevdeskApi\Constants\OrderType::ORDER_CONFIRMATION);
$sevdeskApi->order()->allAccepted(\Exlo89\LaravelSevdeskApi\Constants\OrderType::DELIVERY_NODE);
```

Um Angebote nach Kontakten zu filtern, rufe die Funktion `allByContact()` mit der Kontakt ID als `$contactId` Parameter
auf.

```php
$sevdeskApi->order()->allByContact($contactId);
```

Um Angebote vor oder nach einem bestimmten Datum zu filtern, rufe entweder die `allBefore()` oder die `allAfter()`
Funktion mit dem jeweiligen Zeitstempel `$timestamp` als Parameter auf.
Mit der Funktion `allBetween()` ist es möglich, nach einem bestimmten Zeitraum zu filtern.

```php
$sevdeskApi->order()->allAfter($timestamp);
$sevdeskApi->order()->allBefore($timestamp);
$sevdeskApi->order()->allBetween($startTimestamp, $endTimestamp);
```

## Angebot erstellen

Um ein Angebot zu erstellen, verwende die Funktion `create()`. Füge `customerId` und ein Array deiner Angebotspositionen
hinzu. `$parameters` sind optional. Weitere Informationen findest du in der
offiziellen [API-Dokumentation](https://api.sevdesk.de/#tag/Order/operation/createOrder).

```php
$items = [
    [
        'name' => 'Web Design',
        'price' => 5,
    ],
    [
        'name' => 'Server Hosting',
        'price' => 10,
        'quantity' => 5                 // (optional) standardmäßig auf 1
        'text' => 'Wordpress Server'    // (optional) Beschreibung unter dem Namen
    ],
]
$sevdeskApi->order()->create($customerId, $items, $parameters);
```

## Angebot aktualisieren

Um ein einzelnes Angebot zu aktualisieren. `$orderId` ist erforderlich.

```php
$sevdeskApi->order()->update($orderId, $parameters);
```

## Angebot herunterladen

Um ein Angebot runterzuladen, rufe die Funktion `download()` auf mit der Order ID `$orderId` als Parameter.

```php
$sevdeskApi->order()->download($orderId);
```

## Angebot per E-Mail senden

Um das Angebot an die angegebene `$email` zu senden. Verwende `$subject` und `$text`, um die E-Mail zu
bearbeiten. `$text` kann HTML enthalten.

```php
$sevdeskApi->order()->sendByMail($orderId, $email, $subject, $text);
```
