<?php
namespace App\Events;

use Symfony\Component\EventDispatcher\Event;

class OrderEvent extends Event
{
    const NAME = 'order.event';

    protected $order;

    public function __construct()
    {
        $this->order = 'dummy'; //TODO: Get order
    }

    public function getOrder()
    {
        return $this->order;
    }
}