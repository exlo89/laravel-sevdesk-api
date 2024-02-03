# Invoice

If you want to create invoices you need to set these configs:

```dotenv
SEVDESK_TAX_RATE=19
SEVDESK_TAX_TEXT="Vat 19%"
SEVDESK_TAX_TYPE=default
SEVDESK_CURRENCY=EUR
SEVDESK_INVOICE_TYPE=RE
```
These values are default values but please feel free to change this values.
For the tax type you can choose 5 different types:
- [default] - value added tax
- [eu] - tax-free intra-community supply (European Union)
- [noteu] - tax liability of the recipient (outside the EU, e.g. Switzerland)
- [custom] - using custom tax set
- [ss] - Not subject to VAT according to §19 1 UStG Tax rates are heavily connected to the tax type used.

Also you can choose between 6 different invoice types:

- [RE] A normal invoice which documents a simple selling process.
- [WKR] An invoice which generates normal invoices with the same values regularly in fixed time frames (every month, year, ...).
- [SR] An invoice which cancels another already created normal invoice.
- [MA] An invoice which gets created if the end-customer failed to pay a normal invoice in a given time frame.
  Often includes some kind of reminder fee.
- [TR] Part of a complete invoice. All part invoices together result in the complete invoice.
  Often used if the end-customer can partly pay for items or services.
- [ER] 	The final invoice of all part invoices which completes the invoice.
  After the final invoice is payed by the end-customer, the selling process is complete.

For more details about invoice types click [here](https://api.sevdesk.de/#tag/Invoice/Types-and-status-of-invoices).
## Retrieve Invoice

To get all invoices call the `all()` function.

```php
$sevdeskApi->invoice()->all();
```

To get the invoices filtered by `draft`, `open` or `payed`, call the `allDraft()`,`allOpen()`
or `allPayed()` function.

```php
$sevdeskApi->invoice()->allDraft();
$sevdeskApi->invoice()->allOpen();
$sevdeskApi->invoice()->allPayed();
```

To filter invoices by contact, call the `allByContact()` function with the contact ID as `$contactId`
Parameters.

```php
$sevdeskApi->invoice()->allByContact($contactId);
```

To filter invoices before or after a certain date, call either the `allBefor()` or the `allAfter()` function with the respective timestamp `$timestamp` as a parameter.
function with the respective timestamp `$timestamp` as a parameter. With the `allBetween()` function it is possible to filter
by a specific time period.

```php
$sevdeskApi->invoice()->allAfter($timestamp);
$sevdeskApi->invoice()->allBefore($timestamp);
$sevdeskApi->invoice()->allBetween($startTimestamp, $endTimestamp);
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

## Download Invoice

To download pdf file of the giving `$invoiceId`.

```php
$sevdeskApi->invoice()->download($invoiceId);
```

## Send Invoice By Mail

To send invoice to giving `$email`. Use `$subject` and `$text` to edit the mail. `$text` can contain html.

```php
$sevdeskApi->invoice()->sendPerMail($invoiceId, $email, $subject, $text);
```
