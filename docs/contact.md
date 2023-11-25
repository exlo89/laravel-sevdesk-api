# Contact

## Create Contact

Create sevdesk contacts. There are 4 different default contact types in sevdesk.

- supplier
- customer
- partner
- prospect customer

The optional `$parameters` is for additional information like description, vatNumber or bankNumber.

```php
$sevdeskApi->contact()->createSupplier('Supplier Organisation', $parameters);
$sevdeskApi->contact()->createCustomer('Customer Organisation', $parameters);
$sevdeskApi->contact()->createPartner('Partner Organisation', $parameters);
$sevdeskApi->contact()->createProspectCustomer('Prospect Customer Organisation', $parameters);
```

For custom contact types use your custom category id.

```php
$sevdeskApi->contact()->createCustom('Custom Organisation', $categoryId, $parameters);
```

Check [Create Contact](https://my.sevdesk.de/api/ContactAPI/doc.html#operation/createContact) for more information.

## Retrieve Contact

To get all contacts.

```php
$sevdeskApi->contact()->all();
$sevdeskApi->contact()->allSupplier();
$sevdeskApi->contact()->allCustomer();
$sevdeskApi->contact()->allPartner();
$sevdeskApi->contact()->allProspectCustomer();
```

To get all contacts from a custom type.

```php
$sevdeskApi->contact()->allCustom($categoryId);
```

To get a single contact.

```php
$sevdeskApi->contact()->get($contactId);
```

## Update Contact

To update a single contact. `$contactId` is required.

```php
$sevdeskApi->contact()->update($contactId, $parameters);
```

## Delete Contact

To delete a single contact. `$contactId` is required.

```php
$sevdeskApi->contact()->delete($contactId);
```
