# Gutschriften
Wenn du Gutschriften erstellen willst, benötigst du folgende Konfigurationen:

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

Außerdem kannst du zwischen 6 verschiedenen Gutschriftstypen wählen:

- [RE] Eine normale Gutschrift, die einen einfachen Verkaufsvorgang dokumentiert.
- [WKR] Eine Gutschrift, die regelmäßig in festen Zeiträumen (monatlich, jährlich, ...) normale Gutschriften mit den gleichen Werten erstellt.
- [SR] Eine Gutschrift, die eine andere bereits erstellte normale Gutschrift storniert.
- [MA] Eine Gutschrift, die erstellt wird, wenn der Endkunde eine normale Gutschrift nicht innerhalb eines bestimmten Zeitrahmens bezahlt hat.
  Enthält oft eine Art Mahngebühr.
- [TR] Teil einer vollständigen Gutschrift. Alle Teilrechnungen zusammen ergeben die Gesamtrechnung.
  Wird oft verwendet, wenn der Endkunde Artikel oder Dienstleistungen teilweise bezahlen kann.
- [ER] Die Schlussrechnung aller Teilrechnungen, die die Gutschrift vervollständigt.
  Nachdem die Schlussrechnung vom Endkunden bezahlt wurde, ist der Verkaufsprozess abgeschlossen.

Für mehr Details klicke [hier](https://api.sevdesk.de/#tag/Invoice/Types-and-status-of-invoices).

## Gutschriften Abfragen

Um alle Gutschriften zu bekommen rufe die `all()` Funktion auf.

```php
$sevdeskApi->creditNote()->all();
```

Um die Gutschriften gefiltert, nach `draft`, `open` or `payed`, zu bekommen rufe die `allDraft()`,`allOpen()`
oder`allPayed()` Funktion auf.

```php
$sevdeskApi->creditNote()->allDraft();
$sevdeskApi->creditNote()->allDelivered();
$sevdeskApi->creditNote()->allPayed();
```

Um Gutschriften vor oder nach einem bestimmten Datum zu filtern rufe entweder die `allBefor()` oder die `allAfter()`
Funktion auf mit dem jeweiligen Zeitstempel `$timestamp` als Parameter. Mit der `allBetween()` Funktion ist es möglich 
nach einem bestimmten Zeitraum zu filtern.

```php
$sevdeskApi->creditNote()->allAfter($timestamp);
$sevdeskApi->creditNote()->allBefore($timestamp);
$sevdeskApi->creditNote()->allBetween($startTimestamp, $endTimestamp);
```

## Gutschrift erstellen

Um eine Gutschrift zu erstellen, verwenden die Funktion `create()`. Fügen die `customerId` und ein Array mit Ihren
Gutschriftsposition hinzu. Die `$Parameter` sind optional. Für weitere Informationen schaue in die
offizielle [API-Dokumentation](https://api.sevdesk.de/#tag/CreditNote/operation/createcreditNote).

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
$sevdeskApi->creditNote()->create($customerId, $items, $parameters);
```

## Gutschrift herunterladen

Um eine Gutschrift runterzuladen, rufe die Funktion `download()` auf mit der Gutschrifts ID `$creditNoteId` als Parameter.

```php
$sevdeskApi->creditNote()->download($creditNoteId);
```

## Gutschrift per Mail versenden

Um eine Gutschrift per E-Mail zu versenden, rufe die Funktion `sendPerMail()` auf mit der Gutschrifts ID `$creditNoteId`.
Die Parameter `$email`, `$subject` und `$text` sind für die E-Mail Bearbeitung zuständig. `$text` kann auch HTML
enthalten.

```php
$sevdeskApi->creditNote()->sendPerMail($creditNoteId, $email, $subject, $text);
```
