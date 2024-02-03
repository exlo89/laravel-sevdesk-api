# Credit notes
If you want to create credit notes, you need the following configurations:

```dotenv
SEVDESK_TAX_RATE=19
SEVDESK_TAX_TEXT="VAT 19%"
SEVDESK_TAX_TYPE=Standard
SEVDESK_CURRENCY=EUR
SEVDESK_INVOICE_TYPE=RE
```
These are all default values. You can customize the values for yourself.

There are 5 different types for the tax type:
- [default] - Show sales tax
- [eu] - Tax-free intra-Community delivery (European Union)
- [noteu] - Tax liability of the recipient (outside the EU, e.g. Switzerland)
- [custom] - user-defined tax rate
- [ss] - not subject to VAT according to §19 1 UStG The tax rates are highly dependent on the tax type used.

You can also choose between 6 different credit note types:

- [RE] A normal credit memo that documents a simple sales transaction.
- [WKR] A credit memo that regularly creates normal credit memos with the same values in fixed periods (monthly, annually, ...).
- [SR] A credit memo that cancels another normal credit memo that has already been created.
- [MA] A credit note that is created when the end customer has not paid a normal credit note within a certain time frame.
  Often includes some kind of reminder fee.
- [TR] Part of a complete credit note. All partial invoices together make up the total invoice.
  Often used when the end customer can pay for items or services in part.
- [ER] The final invoice of all partial invoices that completes the credit note.
  Once the final invoice has been paid by the end customer, the sales process is complete.

For more details click [here](https://api.sevdesk.de/#tag/Invoice/Types-and-status-of-invoices).

## Credit notes queries

To get all credit notes call the `all()` function.

```php
$sevdeskApi->creditNote()->all();
```

To get the credit notes filtered by `draft`, `open` or `payed`, call the `allDraft()`,`allOpen()`
or `allPayed()` function.

```php
$sevdeskApi->creditNote()->allDraft();
$sevdeskApi->creditNote()->allDelivered();
$sevdeskApi->creditNote()->allPayed();
```

To filter credit notes before or after a certain date, call either the `allBefor()` or the `allAfter()` function with 
the respective timestamp `$timestamp` as a parameter. function with the respective timestamp `$timestamp` as a parameter. With the `allBetween()` function it is possible to filter by a specific time period.

```php
$sevdeskApi->creditNote()->allAfter($timestamp);
$sevdeskApi->creditNote()->allBefore($timestamp);
$sevdeskApi->creditNote()->allBetween($startTimestamp, $endTimestamp);
```
## Create credit note

To create a credit note, use the `create()` function. Add the `customerId` and an array with your
credit note item. The `$Parameters` are optional. For more information see the
official [API documentation](https://api.sevdesk.de/#tag/CreditNote/operation/createcreditNote).

```php
$items = [
    [
        'name' => 'Web Design',
        'price' => 5,
    ],
    [
        'name' => 'Server Hosting',
        'price' => 10,
        'quantity' => 5 // (optional) by default it is 1 
        'text' => 'Wordpress Server' // (optional) description under the name
    ],
]
$sevdeskApi->creditNote()->create($customerId, $items, $parameters);
```

## Download credit note

To download a credit note, call the function `download()` with the credit note ID `$creditNoteId` as parameter.

```php
$sevdeskApi->creditNote()->download($creditNoteId);
```

## Send credit note by e-mail

To send a credit note by e-mail, call the function `sendPerMail()` with the credit note ID `$creditNoteId`.
The parameters `$email`, `$subject` and `$text` are responsible for the e-mail processing. `$text` can also contain HTML
can also contain HTML.

```php
$sevdeskApi->creditNote()->sendPerMail($creditNoteId, $email, $subject, $text);
```
