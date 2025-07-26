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
- [WKR] An invoice which generates normal invoices with the same values regularly in fixed time frames (every month,
  year, ...).
- [SR] An invoice which cancels another already created normal invoice.
- [MA] An invoice which gets created if the end-customer failed to pay a normal invoice in a given time frame.
  Often includes some kind of reminder fee.
- [TR] Part of a complete invoice. All part invoices together result in the complete invoice.
  Often used if the end-customer can partly pay for items or services.
- [ER]    The final invoice of all part invoices which completes the invoice.
  After the final invoice is payed by the end-customer, the selling process is complete.

For more details about invoice types click [here](https://api.sevdesk.de/#tag/Invoice/Types-and-status-of-invoices).

## Pagination

All methods that return multiple invoices support pagination through optional parameters:
- `offset`: Skip the first n entries (default: 0)
- `limit`: Maximum number of entries to return (default: 100)

Example usage:
```php
// Get the first 50 invoices
$invoices = $sevdeskApi->invoice()->all(0, 50);

// Get the next 50 invoices
$nextInvoices = $sevdeskApi->invoice()->all(50, 50);

// Get 20 open invoices, starting from the 40th invoice
$openInvoices = $sevdeskApi->invoice()->allOpen(40, 20);
```

This pagination can be used with all list methods:
- `all()`
- `allDraft()`
- `allOpen()`
- `allPayed()`
- `allDue()`
- `allByContact()`
- `allByPaymentMethod()`
- `allBefore()`
- `allAfter()`
- `allBetween()`

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

To get all due invoices call the `allDue()` function.

```php
$sevdeskApi->invoice()->allDue();
```

To filter invoices by contact, call the `allByContact()` function with the contact ID as `$contactId`
Parameters.

```php
$sevdeskApi->invoice()->allByContact($contactId);
```

To filter invoices by payment method, call `allByPaymentMethod()` function with payment method ID as `$paymentMethodId`.
Additionally all other query parameters can be passed via an array.

```php
$sevdeskApi->invoice()->allByPaymentMethod($paymentMethodId,['embed' => 'contact']);
```

To filter invoices before or after a certain date, call either the `allBefore()` or the `allAfter()` function with the
respective timestamp `$timestamp` as a parameter.
function with the respective timestamp `$timestamp` as a parameter. With the `allBetween()` function it is possible to
filter
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

## Invoice Number

The invoice number is a unique identifier for each invoice. You can create the invoice number manually by add it as a
parameter.

```php
$parameters = [
    'invoiceNumber' => '1234' 
];
$sevdeskApi->invoice()->create($customerId, $items, $parameters);
```

Or you can create the invoice number automatically by calling the `getSequence()` function and add this to the
parameters.

```php
// create invoice number automatically
$sequence = $sevdeskApi->invoice()->getSequence();
// add invoice number to parameters
$parameters = [
    'invoiceNumber' => $sequence->nextSequence
];
// create invoice
$sevdeskApi->invoice()->create($customerId, $items, $parameters);
```

> **_NOTE:_**  Only the sequence object is returned with the sequence number. 
> If you want to have date formats (e.g %YYYY), you have to implement them yourself.

## Create Reminder

To create an invoice use the `createReminder()` function and pass the SevDesk `invoiceId`.

```php
$sevdeskApi->invoice()->createReminder($invoiceId);
```

## Download Invoice

To download pdf file of the giving `$invoiceId`.

```php
$sevdeskApi->invoice()->download($invoiceId);
```

## Send Invoice By Mail

To send invoice to giving `$email`. Use `$subject` and `$text` to edit the mail. `$text` can contain html.

```php
$sevdeskApi->invoice()->sendByMail($invoiceId, $email, $subject, $text);
```

## Send Invoice By Custom Type

To send invoice by custom type, you can use the `sendBy()` function. The `$sendType` can be one of the following:
- VPR = printed
- VPDF = downloaded 
- VM = mailed
- VP = postal

```php
$sendType = InvoiceSendType::VM;

$sevdeskApi->invoice()->sendBy($invoiceId, $sendType);
```
