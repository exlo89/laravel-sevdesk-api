# Invoice

## Retrieve Invoice

To get all invoices.

```php
$sevdeskApi->invoice()->all();
```

To get all invoices filtered by status `draft`, `open` or `payed`.

```php
$sevdeskApi->invoice()->allDraft();
$sevdeskApi->invoice()->allOpen();
$sevdeskApi->invoice()->allPayed();
```

To get all invoices filtered by a giving `$contactId`.

```php
$sevdeskApi->invoice()->allByContact($contactId);
```

To get all invoices filtered by giving `$timestamp`.

```php
$sevdeskApi->invoice()->allAfter($timestamp);
$sevdeskApi->invoice()->allBefore($timestamp);
```

To download pdf file of the giving `$invoiceId`.

```php
$sevdeskApi->invoice()->download($invoiceId);
```

To send invoice to giving `$email`. Use `$subject` and `$text` to edit the mail. `$text` can contain html.

```php
$sevdeskApi->invoice()->sendPerMail($invoiceId, $email, $subject, $text);
```

## Create Invoice

To create an invoice use the `create()` function. Add `customerId` and an array of your invoice items. `$parameters` are
optional. For further information look at the
official [API documentation](https://api.sevdesk.de/#tag/Invoice/operation/createInvoiceByFactory).

```php
$items = [
    [
        'name' => 'Web Design',
        'price' => 5,
    ],
    [
        'name' => 'Server Hosting',
        'price' => 10,
        'quantity' => 5                 // (optional) by default it's 1 
        'text' => 'Wordpress Server'    // (optional) description below name
    ],
]
$sevdeskApi->invoice()->create($customerId, $items, $parameters);
```
