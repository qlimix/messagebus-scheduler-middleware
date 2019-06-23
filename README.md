# messagebus-scheduler-middleware

[![Travis CI](https://api.travis-ci.org/qlimix/messagebus-scheduler-middleware.svg?branch=master)](https://travis-ci.org/qlimix/messagebus-scheduler-middleware)
[![Coveralls](https://img.shields.io/coveralls/github/qlimix/messagebus-scheduler-middleware.svg)](https://coveralls.io/github/qlimix/messagebus-scheduler-middleware)
[![Packagist](https://img.shields.io/packagist/v/qlimix/messagebus-scheduler-middleware.svg)](https://packagist.org/packages/qlimix/messagebus-scheduler-middleware)
[![MIT License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](https://github.com/qlimix/messagebus-scheduler-middleware/blob/master/LICENSE)

Schedule messages via the messagebus with this middleware.

## Install

Using Composer:

~~~
$ composer require qlimix/messagebus-scheduler-middleware
~~~

## usage
```php
<?php

use Qlimix\MessageBus\MessageBus\Middleware\SchedulerMiddleware;

$scheduler = new FooBarScheduler();

$schedulerMiddleware = new SchedulerMiddleware($scheduler, new DateInterval('P1D'));
```

## Testing
To run all unit tests locally with PHPUnit:

~~~
$ vendor/bin/phpunit
~~~

## Quality
To ensure code quality run grumphp which will run all tools:

~~~
$ vendor/bin/grumphp run
~~~

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.
