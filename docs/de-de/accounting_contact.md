# Buchhaltungskontakt

## Kontakt erstellen

Für Buchhaltungskontakte musst du zuerst einen [Kontakt](de-de/contact.md) erstellen. Du erstellst einen Buchhaltungskontakt mit der erstellten Kontakt-ID.

```php
$sevdeskApi->accountingContact()->create($contactId);
```

## Kontakt abrufen

Um alle Kontakte zu erhalten.

```php
$sevdeskApi->accountingContact()->all();
```

Um einen einzelnen Kontakt zu erhalten.

```php
$sevdeskApi->accountingContact()->get($accountingContactId);
```

Um einen einzelnen Kontakt einer `$contactId` zu erhalten.

```php
$sevdeskApi->accountingContact()->getByContact($contactId);
```

## Kontakt aktualisieren

Um einen einzelnen Kontakt zu aktualisieren. `$accountingContactId` ist erforderlich.

```php
$sevdeskApi->accountingContact()->update($accountingContactId, $parameters);
```

## Kontakt löschen

Um einen einzelnen Kontakt zu löschen. `$accountingContactId` ist erforderlich.

```php
$sevdeskApi->accountingContact()->delete($accountingContactId);
```
