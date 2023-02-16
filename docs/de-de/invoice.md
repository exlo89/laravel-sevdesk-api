# Rechnungen

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
Funktion auf mit dem jeweiligen Zeitstempel `$timestamp` als Parameter.

```php
$sevdeskApi->invoice()->allAfter($timestamp);
$sevdeskApi->invoice()->allBefore($timestamp);
```

Um eine Rechnung runterzuladen, rufe die Funktion `donwload()` auf mit der Rechnungs ID `$invoiceId` als Parameter.

```php
$sevdeskApi->invoice()->download($invoiceId);
```

Um eine Rechnung per E-Mail zu versenden, rufe die Funktion `sendPerMail()` auf mit der Rechnungs-ID `$invoiceId`.
Die Parameter `$email`, `$subject` und `$text` sind für die E-Mail Bearbeitung zuständig. `$text` kann auch HTML
enthalten.

```php
$sevdeskApi->invoice()->sendPerMail($invoiceId, $email, $subject, $text);
```
