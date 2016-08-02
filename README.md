# SmsIntel PHP Api

<p align="center">
    <img src="logo.jpg" alt="Pinterest PHP Bot">
</p>

<p align="center">
[![Build Status](https://travis-ci.org/seregazhuk/php-smsintel-api.svg?branch=master)](https://travis-ci.org/seregazhuk/php-smsintel-api)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/seregazhuk/php-smsintel-api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/seregazhuk/php-smsintel-api/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/seregazhuk/smsintel-api/v/stable)](https://packagist.org/packages/seregazhuk/smsintel-api)
[![Total Downloads](https://poser.pugx.org/seregazhuk/smsintel-api/downloads)](https://packagist.org/packages/seregazhuk/smsintel-api)
</p>

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