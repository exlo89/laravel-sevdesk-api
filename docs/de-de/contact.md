# Kontakt

## Kontakt erstellen

Erstelle Sevdesk-Kontakte. Es gibt 4 verschiedene Standard-Kontakttypen in Sevdesk.

- Lieferant
- Kunde
- Partner
- potenzieller Kunde

Die optionale `$parameters` dient zusätzlichen Informationen wie Beschreibung, USt-IDNr. oder Banknummer.

```php
$sevdeskApi->contact()->createSupplier('Lieferantenorganisation', $parameters);
$sevdeskApi->contact()->createCustomer('Kundenorganisation', $parameters);
$sevdeskApi->contact()->createPartner('Partnerorganisation', $parameters);
$sevdeskApi->contact()->createProspectCustomer('Organisation potenzieller Kunde', $parameters);
```

Für benutzerdefinierte Kontakttypen verwende deine benutzerdefinierte Kategorie-ID.

```php
$sevdeskApi->contact()->createCustom('Benutzerdefinierte Organisation', $categoryId, $parameters);
```

Siehe [Kontakt erstellen](https://my.sevdesk.de/api/ContactAPI/doc.html#operation/createContact) für weitere Informationen.

## Kontakt abrufen

Um alle Kontakte zu erhalten.

```php
$sevdeskApi->contact()->all();
$sevdeskApi->contact()->allSupplier();
$sevdeskApi->contact()->allCustomer();
$sevdeskApi->contact()->allPartner();
$sevdeskApi->contact()->allProspectCustomer();
```

Um alle Kontakte eines benutzerdefinierten Typs zu erhalten.

```php
$sevdeskApi->contact()->allCustom($categoryId);
```

Um einen einzelnen Kontakt zu erhalten.

```php
$sevdeskApi->contact()->get($contactId);
```

## Kontakt aktualisieren

Um einen einzelnen Kontakt zu aktualisieren. `$contactId` ist erforderlich.

```php
$sevdeskApi->contact()->update($contactId, $parameters);
```

## Kontakt löschen

Um einen einzelnen Kontakt zu löschen. `$contactId` ist erforderlich.

```php
$sevdeskApi->contact()->delete($contactId);
```
