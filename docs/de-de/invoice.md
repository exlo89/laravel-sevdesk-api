# Rechnungen
Wenn du Rechnungen erstellen willst, benötigst du folgende Konfigurationen:

```dotenv
SEVDESK_TAX_RATE=19
SEVDESK_TAX_TEXT="Mehrwertsteuer 19%"
SEVDESK_TAX_TYPE=Standard
SEVDESK_CURRENCY=EUR
SEVDESK_INVOICE_TYPE=RE
```
Das sind alles Standartwerte. Du kannst die Werte für dich anpassen.

Für die Tax Type gibt es 5 verschiedene Arten:
- [default] - Umsatzsteuer ausweisen
- [eu] - Steuerfreie innergemeinschaftliche Lieferung (Europäische Union)
- [noteu] - Steuerschuldnerschaft des Leistungsempfängers (außerhalb EU, z. B. Schweiz)
- [custom] - benutzerdefinierter Steuersatz
- [ss] - nicht umsatzsteuerpflichtig nach §19 1 UStG Die Steuersätze sind stark von der verwendeten Steuerart abhängig.

Außerdem kannst du zwischen 6 verschiedenen Rechnungstypen wählen:

- [RE] Eine normale Rechnung, die einen einfachen Verkaufsvorgang dokumentiert.
- [WKR] Eine Rechnung, die regelmäßig in festen Zeiträumen (monatlich, jährlich, ...) normale Rechnungen mit den gleichen Werten erstellt.
- [SR] Eine Rechnung, die eine andere bereits erstellte normale Rechnung storniert.
- [MA] Eine Rechnung, die erstellt wird, wenn der Endkunde eine normale Rechnung nicht innerhalb eines bestimmten Zeitrahmens bezahlt hat.
  Enthält oft eine Art Mahngebühr.
- [TR] Teil einer vollständigen Rechnung. Alle Teilrechnungen zusammen ergeben die Gesamtrechnung.
  Wird oft verwendet, wenn der Endkunde Artikel oder Dienstleistungen teilweise bezahlen kann.
- [ER] Die Schlussrechnung aller Teilrechnungen, die die Rechnung vervollständigt.
  Nachdem die Schlussrechnung vom Endkunden bezahlt wurde, ist der Verkaufsprozess abgeschlossen.

Für mehr Details klicke [hier](https://api.sevdesk.de/#tag/Invoice/Types-and-status-of-invoices).

## Pagination

Alle Methoden, die mehrere Rechnungen zurückgeben, unterstützen Pagination durch optionale Parameter:
- `offset`: Überspringe die ersten n Einträge (Standard: 0)
- `limit`: Maximale Anzahl der zurückzugebenden Einträge (Standard: 100)

Beispiel Verwendung:
```php
// Hole die ersten 50 Rechnungen
$invoices = $sevdeskApi->invoice()->all(0, 50);

// Hole die nächsten 50 Rechnungen
$nextInvoices = $sevdeskApi->invoice()->all(50, 50);

// Hole 20 offene Rechnungen, beginnend ab der 40. Rechnung
$openInvoices = $sevdeskApi->invoice()->allOpen(40, 20);
```

Diese Pagination kann mit allen List-Methoden verwendet werden:
- `all()`
- `allDraft()`
- `allOpen()`
- `allPayed()`
- `allDue()`
- `allByContact()`
- `allByPaymentMethod()`
- `allBefore()`
- `allAfter()`
- `allBetween()`

## Rechnungen Abfragen

Um alle Rechnungen zu bekommen, rufe die `all()` Funktion auf.

```php
$sevdeskApi->invoice()->all();
```

Um die Rechnungen gefiltert, nach `draft`, `open` or `payed`, zu bekommen rufe die `allDraft()`,`allOpen()`
oder`allPayed()` Funktion auf.

```php
$sevdeskApi->invoice()->allDraft();
$sevdeskApi->invoice()->allOpen();
$sevdeskApi->invoice()->allPayed();
```

Um alle fälligen Rechnungen zu bekommen rufe die `allDue()` Funktion auf.

```php
$sevdeskApi->invoice()->allDue();
```

Um Rechnungen nach Kontakt zu filtern, rufe die `allByContact()` Funktion auf mit der Kontakt ID als `$contactId`
Parameter.

```php
$sevdeskApi->invoice()->allByContact($contactId);
```

Um Rechnungen nach Zahlungsart zu filtern, rufe die `allByPaymentMethod()` Funktion auf mit der Zahlungsart ID als `$paymentMethodId`
Parameter.
Zusätzlich können alle anderen parameter wie embed über ein Array übergeben werden.

```php
$sevdeskApi->invoice()->allByPaymentMethod($paymentMethodId,['embed' => 'contact']);
```

Um Rechnungen vor oder nach einem bestimmten Datum zu filtern rufe entweder die `allBefore()` oder die `allAfter()`
Funktion auf mit dem jeweiligen Zeitstempel `$timestamp` als Parameter. Mit der `allBetween()` Funktion ist es möglich 
nach einem bestimmten Zeitraum zu filtern.

```php
$sevdeskApi->invoice()->allAfter($timestamp);
$sevdeskApi->invoice()->allBefore($timestamp);
$sevdeskApi->invoice()->allBetween($startTimestamp, $endTimestamp);
```

## Rechnung erstellen

Um eine Rechnung zu erstellen, verwenden die Funktion `create()`. Fügen die `customerId` und ein Array mit Ihren
Rechnungsposition hinzu. Die `$Parameter` sind optional. Für weitere Informationen schaue in die
offizielle [API-Dokumentation](https://api.sevdesk.de/#tag/Invoice/operation/createInvoiceByFactory).

```php
$items = [
    [
        'name' => 'Web Design',
        'Preis' => 5,
    ],
    [
        'name' => 'Server Hosting',
        'Preis' => 10,
        'quantity' => 5 // (optional) standardmäßig ist es 1 
        'text' => 'Wordpress Server' // (optional) Beschreibung unter dem Namen
    ],
]
$sevdeskApi->invoice()->create($customerId, $items, $parameters);
```

## Rechnungsnummer

Die Rechnungsnummer ist eine eindeutige Kennung für jede Rechnung. Erstelle die Rechnungsnummer manuell, indem du sie als
Parameter hinzufügst.

```php
$parameters = [
    'invoiceNumber' => '1234' 
];
$sevdeskApi>invoice()->create($customerId, $items, $parameters);
```

Oder lass die Rechnungsnummer automatisch erstellen, indem du die Funktion `getSequence()` aufrufst und diese zu den
Parameter hinzufügen.

```php
// erstelle die Rechnungsnummer automatisch
$sequence = $sevdeskApi->creditNote()->getSequence();
// füge die Rechnungsnummer zu den Parametern hinzu
$parameters = [
    'invoiceNumber' => $sequence->nextSequence
];
// erstelle die Rechnung
$sevdeskApi>invoice()->create($customerId, $items, $parameters);
```

## Zahlungserinnerung erstellen

Um eine Zahlungserinnerung zu erstellen, verwende die Funktion `createReminder()` und übergebe die SevDesk `invoiceId`.

```php
$sevdeskApi->invoice()->createReminder($invoiceId);
```

## Rechnung herunterladen

Um eine Rechnung runterzuladen, rufe die Funktion `download()` auf mit der Rechnungs ID `$invoiceId` als Parameter.

```php
$sevdeskApi->invoice()->download($invoiceId);
```

## Rechnung per Mail versenden

Um eine Rechnung per E-Mail zu versenden, rufe die Funktion `sendPerMail()` auf mit der Rechnungs-ID `$invoiceId`.
Die Parameter `$email`, `$subject` und `$text` sind für die E-Mail Bearbeitung zuständig. `$text` kann auch HTML
enthalten.

```php
$sevdeskApi->invoice()->sendByMail($invoiceId, $email, $subject, $text);
```


## Rechnung per benutzerdefiniertem Typ versenden

Um eine Rechnung per benutzerdefiniertem Typ zu versenden, kannst du die Funktion `sendBy()` verwenden. 
Der Parameter `$sendType` kann einer der folgenden Werte sein:

- VPR = gedruckt
- VPDF = heruntergeladen
- VM = per E-Mail versendet
- VP = per Post versendet

```php
$sendType = InvoiceSendType::VM;

$sevdeskApi->invoice()->sendBy($invoiceId, $sendType);
```
