# pmill/rabbit-rabbit-statsd

## Introduction

This library is an integration for [pmill/rabbit-rabbit](https://github.com/pmill/rabbit-rabbit) allows you to send your
RabbitMQ message counts to StatsD.

## Requirements

This library package requires PHP 7.1 or later, and a previously setup StatsD server.

## Installation

The recommended way to install is through [Composer](http://getcomposer.org).

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Next, run the Composer command to install the latest version:

```bash
composer require pmill/rabbit-rabbit-statsd
```

# Usage

The following example will post the message count for your queue to your StatsD metric. There is a complete example in 
the `examples/` folder.

```php
$config = new RabbitConfig([
    'baseUrl' => 'localhost:15672',
    'username' => 'guest',
    'password' => 'guest',
]);

$manager = new ConsumerManager($config);

$vhostName = '/';
$queueName = 'messages';
$metric = 'message_queue_count';

$statsDClient = new StatsDClient();
$statsDClient->configure([
    'host' => '127.0.0.1',
    'port' => 8125,
    'namespace' => 'example'
]);

$manager->addRule(
    new StatsDRule(
        $vhostName,
        $queueName,
        $statsDClient,
        $metric
    ),
    new GreaterThan(0)
);

$manager->run();
```

# Version History

0.1.1 (22/04/2018)

*   Bugfix - Fixed metric name variable format

0.1.0 (18/04/2018)

*   First public release of rabbit-rabbit-statsd


# Copyright

pmill/rabbit-rabbit-statsd
Copyright (c) 2018 pmill (dev.pmill@gmail.com) 
All rights reserved.