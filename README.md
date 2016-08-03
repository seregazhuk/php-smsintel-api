# SmsIntel PHP Api

<p align="center">
    <img src="logo.png" alt="Pinterest PHP Bot">
</p>

<p align="center">
<a href="https://travis-ci.org/seregazhuk/php-smsintel-api"><img src="https://travis-ci.org/seregazhuk/php-smsintel-api.svg?branch=master"></a>
<a href="https://scrutinizer-ci.com/g/seregazhuk/php-smsintel-api/?branch=master"><img src="https://scrutinizer-ci.com/g/seregazhuk/php-smsintel-api/badges/quality-score.png?b=master"></a>
<a href="https://codeclimate.com/github/seregazhuk/php-smsintel-api"><img src="https://codeclimate.com/github/seregazhuk/php-smsintel-api/badges/gpa.svg" /></a>
<a href="https://codeclimate.com/github/seregazhuk/php-smsintel-api/coverage"><img src="https://codeclimate.com/github/seregazhuk/php-smsintel-api/badges/coverage.svg" /></a>
<a href="https://packagist.org/packages/seregazhuk/smsintel-api"><img src="https://poser.pugx.org/seregazhuk/smsintel-api/v/stable"></a>
<a href="https://packagist.org/packages/seregazhuk/smsintel-api"><img src="https://poser.pugx.org/seregazhuk/smsintel-api/downloads"></a>
</p>

Library provides common interface for making requests to both XML and JSON [smsintel API](http://www.smsintel.ru/integration/).

- [Dependencies](#dependencies)
- [Installation](#installation)
- [Quick Start](#quick-start)
- [Sending messages](#sending-messages)
- [Groups and contacts](#groups-and-contacts)
- [Account](#account)
- [Reports](#reports)

## Dependencies
Library requires CURL extension and PHP 5.5.9 or above.

## Installation
Via composer:
```
composer require "seregazhuk/smsintel-api:*"
```

## Quick Start

```php 
// You may need to amend this path to locate composer's autoloader
require('vendor/autoload.php'); 

use seregazhuk\SmsIntel\Factories\SmsIntel;

$sender = SmsIntel::create('login', 'password');

// send sms
$result = $sender->send('phoneNumber', 'From', 'Your message text');

```

## Sending messages

To send message to one phone number:

```php
$result = $sender->send('phoneNumber', 'From', 'Your message text');
```

You can pass an array of phones:

```php
$phones = [
 '79999999999'
 '79999999991'
 '79999999992'
];
$result = $sender->send($phones, 'From', 'Your message text');
```

Cancel sms by id:
 
```php
$result = $sender->cancel($smsId);
```

Request a source name:

```php
$result = $sender->requestSource('FromPHP');
```

## Groups and contacts

Get contact info by phone number:

```php
$contact = $sender->getPhoneInfo('79999999999');
```

Get all contacts:

```php	
$contacts = $sender->getContacts();
```

Contacts for specific group:

```php
$groupId = 1;
$contacts = $sender->getContacts($groupId);
```

Contacts by phone number:
```php
$phone = '79999999999;
$contacts = $sender->getContacts(null, $phone);

// or with group:
$groupId = 1;
$contacts = $sender->getContacts($groupId, $phone);
```

Create a new contact:

```php
$contactInfo = [
	'idGroup' => 1 // required
	'phone'   => '79999999999 // required
	'f'       => 'Second Name',
	'i'       => 'First Name',
	'o'       => 'Middle Name',
	'bday'    => 'YYYY-mm-dd',
	'sex'     => 1 // 1 - male, 2 - female
];
$result = $sender->addContact($contactInfo);
```

Remove contact by phone number:

```php
$sender->removeContact('79999999999');
```

You can pass optionally group id:

```php
$groupId = 1;
$sender->removeContact('79999999999', $groupId);
```

Get all groups:
```php
$groups = $send->getGroups();
```

Get group by id or name:
```php
$groups = $sender->getGroups($groupId);
$groups = $sender->getGroups(null, $groupName);
```

Create a new group of contacts:

```php
$result = $sender->createGroup('NewGroup');
```

Edit group name by id:

```php
$result = $sender->editGroup($newName, $groupId);
```

## Account

Get account info: 

```php
$result = $sender->getAccountInfo();
```

Get balance:

```php
$result = $sender->getBalance();
```

Use discount coupon:

```php
$result = $sender->checkCoupon('couponCode');
```

Only check discount coupon:

```php
$result = $sender->checkCoupon('couponCode', false);
```

## Reports

Get report for period by phone number:

```php
$result = $sender->getReportByNumber($dateFrom, $dateTo, '79999999999');
```

Get report for period and for all numbers:

```php
$result = $sender->getReportByNumber($dateFrom, $dateTo);
```

Get report by smsId:

```php
$result = $sender->getReportBySms($smsId);
```

Get report for period by source:

```php
$result = $sender->getReportBySource($dateFrom, $dateTo, 'FromPHP');
```

Get report for period for all sources:

```php
$result = $sender->getReportBySource($dateFrom, $dateTo);
```