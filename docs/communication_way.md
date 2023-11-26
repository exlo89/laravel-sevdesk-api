# Communication Way

## Create Communication Way

Create phone number.

```php
$sevdeskApi->communicationWay()->createPhone($contactId, $phoneNumber);
```

Create email.

```php
$sevdeskApi->communicationWay()->createEmail($contactId, $email);
```

Create website.

```php
$sevdeskApi->communicationWay()->createWebsite($contactId, $website);
```

## Retrieve Communication Way

Retrieve all communication ways.

```php
$sevdeskApi->communicationWay()->all();
```

Retrieve communication ways of a specific contact.

```php
$sevdeskApi->communicationWay()->get($contactId);
```

## Delete Communication Way

To delete a single communication way.

```php
$sevdeskApi->communicationWay()->delete($communicationWayId);
```
