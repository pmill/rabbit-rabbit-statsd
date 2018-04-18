<?php

use League\StatsD\Client as StatsDClient;
use pmill\RabbitRabbit\Conditions\GreaterThan;
use pmill\RabbitRabbit\ConsumerManager;
use pmill\RabbitRabbit\RabbitConfig;
use pmill\RabbitRabbitStatsD\StatsDRule;

require __DIR__ . '/../vendor/autoload.php';

$config = new RabbitConfig([
    'baseUrl' => 'localhost:15672',
    'username' => 'guest',
    'password' => 'guest',
]);

$manager = new ConsumerManager($config);
$vhostName = '/';
$queueName = 'messages';

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
        'rabbitmq_{vhostName}_{queueName}'
    ),
    new GreaterThan(0)
);

$manager->run();
