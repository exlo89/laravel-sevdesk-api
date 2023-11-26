# Kommunikation Weg

## Kommunikationsweg erstellen

Telefonnummer erstellen.

```php
$sevdeskApi->communicationWay()->createPhone($contactId, $phoneNumber);
```

E-Mail erstellen.

```php
$sevdeskApi->communicationWay()->createEmail($contactId, $email);
```

Website erstellen.

```php
$sevdeskApi->communicationWay()->createWebsite($contactId, $website);
```

## Kommunikationsweg abrufen

Alle Kommunikationswege abrufen.

```php
$sevdeskApi->communicationWay()->all();
```

Abrufen der Kommunikationswege eines bestimmten Kontakts.

```php
$sevdeskApi->communicationWay()->get($contactId);
```

## Kommunikationsweg löschen

Um einen einzelnen Kommunikationsweg zu löschen.

```php
$sevdeskApi->Kommunikationsweg()->löschen($communicationWayId);
```
