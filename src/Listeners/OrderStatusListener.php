<?php

namespace App\Listeners;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Event;

class OrderStatusListener
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onStatusChangeEvent(Event $event)
    {
        // fetch event information here
        $this->logger->info("Order status updated");
    }
}