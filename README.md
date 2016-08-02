# SmsIntel PHP Api

[![Build Status](https://travis-ci.org/seregazhuk/php-smsintel-api.svg?branch=master)](https://travis-ci.org/seregazhuk/php-smsintel-api)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/seregazhuk/php-smsintel-api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/seregazhuk/php-smsintel-api/?branch=master)

You can make requests to [smsintel API](http://www.smsintel.ru/integration/) to manage your sms.

- [Dependencies](#dependencies)
- [Installation](#installation)
- [Quick Start](#quick-start)

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