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

## Rechnungen Abfragen

Um alle Rechnungen zu bekommen rufe die `all()` Funktion auf.

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

Um Rechnungen nach Kontakt zu filtern, rufe die `allByContact()` Funktion auf mit der Kontakt ID als `$contactId`
Parameter.

```php
$sevdeskApi->invoice()->allByContact($contactId);
```

Um Rechnungen vor oder nach einem bestimmten Datum zu filtern rufe entweder die `allBefor()` oder die `allAfter()`
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
$sevdeskApi->invoice()->sendPerMail($invoiceId, $email, $subject, $text);
```
