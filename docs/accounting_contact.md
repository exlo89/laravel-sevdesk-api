# Accounting contact

## Create contact

For accounting contacts, you must first create a [contact](de-de/contact.md). You create an accounting contact with the created contact ID.

```php
$sevdeskApi->accountingContact()->create($contactId);
```

## Retrieve contact

To get all contacts.

```php
$sevdeskApi->accountingContact()->all();
```

To get a single contact.

```php
$sevdeskApi->accountingContact()->get($accountingContactId);
```

To get a single contact of a `$contactId`.

```php
$sevdeskApi->accountingContact()->getByContact($contactId);
```

## Update contact

To update a single contact. `$accountingContactId` is required.

```php
$sevdeskApi->accountingContact()->update($accountingContactId, $parameters);
```

## Delete contact

To delete a single contact. `$accountingContactId` is required.

```php
$sevdeskApi->accountingContact()->delete($accountingContactId);
```
