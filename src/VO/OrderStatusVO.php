<?php

namespace App\VO;

class OrderStatusVO
{

    protected $value;

    public function __construct(string $status)
    {
        $this->setStatus($status);
    }

    public function setStatus(string $status)
    {
        $this->value = $status;
    }

    public function getStatus() : string
    {
        return $this->value;
    }

    public function __toString() : string
    {
        return (string) $this->getStatus();
    }
}