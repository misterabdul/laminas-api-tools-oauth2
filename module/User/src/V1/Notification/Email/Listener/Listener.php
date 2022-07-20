<?php

/**
 * Abstract listener
 *
 * @link
 * @copyright Copyright (c) 2015
 */

namespace User\V1\Notification\Email\Listener;

use Laminas\EventManager\ListenerAggregateInterface;
use Laminas\EventManager\ListenerAggregateTrait;
use Psr\Log\LoggerAwareTrait;

abstract class Listener implements ListenerAggregateInterface
{
    use LoggerAwareTrait,
        ListenerAggregateTrait;

    /**
     * @var \Aqilix\Service\ProcessBuilder
     */
    protected $processBuilder;

    /**
     * Construct Listener
     *
     * @param  \Aqilix\Service\ProcessBuilder  $processBuilder
     * @param  \Psr\Log\LoggerAwareInterface  $logger
     */
    public function __construct(
        $processBuilder,
        $logger
    ) {
        $this->processBuilder = $processBuilder;
        $this->logger = $logger;
    }
}
