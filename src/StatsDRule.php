<?php
namespace pmill\RabbitRabbitStatsD;

use League\StatsD\Client as StatsDClient;
use pmill\RabbitRabbit\AbstractRule;

class StatsDRule extends AbstractRule
{
    /**
     * @var StatsDClient
     */
    protected $statsDClient;

    /**
     * @var string
     */
    protected $metric;

    /**
     * StatsDRule constructor.
     *
     * @param string $vHostName
     * @param string $queueName
     * @param StatsDClient $statsDClient
     * @param string $metric
     */
    public function __construct(
        string $vHostName,
        string $queueName,
        StatsDClient $statsDClient,
        string $metric
    ) {
        $this->statsDClient = $statsDClient;
        $this->metric = $metric;

        parent::__construct($vHostName, $queueName);
    }

    /**
     * @param int $readyMessageCount
     */
    public function run(int $readyMessageCount): void
    {
        $metric = $this->metric;
        $metric = str_replace('{queueName}', $this->queueName, $metric);
        $metric = str_replace('{vhostName}', $this->vHostName, $metric);

        $this->statsDClient->set($metric, $readyMessageCount);
    }
}
