# Order

Similar to [invoice](invoice.md): If you want to create orders you need to set some configurations in your `.env` file.

```dotenv
SEVDESK_TAX_RATE=19
SEVDESK_TAX_TEXT="Vat 19%"
SEVDESK_TAX_TYPE=default
SEVDESK_TAX_RULE=1
SEVDESK_CURRENCY=EUR
```

> **_Version 2.0:_** You need `SEVDESK_TAX_RULE` for API version 2.0.

The default order type is `AN` but you can choose between 3 different order types:

- [AN] A normal order which documents a simple estimation / proposal for an end-customer.
- [AB] A confirmation for an estimate / proposal.
- [LI] A confirmation that goods from an estimate / proposal have been sent.

There is an order type constant class in the package. You can use it like this:

```php
use Exlo89\LaravelSevdeskApi\Constants\OrderType;   // import the class

$sevdeskApi->order()->all(OrderType::PROPOSAL);     // use it for example to filter by order type
```

For more details about order types click [here](https://api.sevdesk.de/#tag/Order/Types-and-status-of-orders).

## Retrieve Order

To get all orders call the `all()` function.

```php
$sevdeskApi->order()->all();
```

To get the orders filtered by status use one of these functions.
All of these function have an optional parameter `$orderType` to filter by order type.
[Here](https://api.sevdesk.de/#tag/Order/Types-and-status-of-orders) are an overview of the possible statuses and types.

```php
$sevdeskApi->order()->allDraft();
$sevdeskApi->order()->allDelivered();
$sevdeskApi->order()->allCancelled();
$sevdeskApi->order()->allAccepted();
$sevdeskApi->order()->allPartialCalculated();
$sevdeskApi->order()->allCalculated();

// with order type
$sevdeskApi->order()->all(\Exlo89\LaravelSevdeskApi\Constants\OrderType::PROPOSAL);
$sevdeskApi->order()->allCancelled(\Exlo89\LaravelSevdeskApi\Constants\OrderType::ORDER_CONFIRMATION);
$sevdeskApi->order()->allAccepted(\Exlo89\LaravelSevdeskApi\Constants\OrderType::DELIVERY_NODE);
```

To filter orders by contact, call the `allByContact()` function with the contact ID as `$contactId`
Parameters.

```php
$sevdeskApi->order()->allByContact($contactId);
```

To filter orders before or after a certain date, call either the `allBefore()` or the `allAfter()` function with the
respective timestamp `$timestamp` as a parameter.
function with the respective timestamp `$timestamp` as a parameter. With the `allBetween()` function it is possible to
filter by a specific time period.

```php
$sevdeskApi->order()->allAfter($timestamp);
$sevdeskApi->order()->allBefore($timestamp);
$sevdeskApi->order()->allBetween($startTimestamp, $endTimestamp);
```

## Create Order

To create an order use the `create()` function. Add `customerId` and an array of your order items. `$parameters` are
optional. For further information look at the
official [API documentation](https://api.sevdesk.de/#tag/Order/operation/createOrder).

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
$sevdeskApi->order()->create($customerId, $items, $parameters);
```

## Update Order

To update a single order. `$orderId` is required.

```php
$sevdeskApi->order()->update($orderId, $parameters);
```

## Download Order

To download pdf file of the giving `$orderId`.

```php
$sevdeskApi->order()->download($orderId);
```

## Send Order By Mail

To send order to giving `$email`. Use `$subject` and `$text` to edit the mail. `$text` can contain html.

```php
$sevdeskApi->order()->sendByMail($orderId, $email, $subject, $text);
```
