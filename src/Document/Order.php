<?php

namespace App\Document;

use App\Document\OrderLine;
use App\VO\OrderStatusVO;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;


/**
 * @MongoDB\Document
 */
class Order
{

    /**
     * @MongoDB\Id
     */
    private $id;

    /**
     * @MongoDB\Field(type="int")
     */
    private $order_id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $status;

    /**
     * @MongoDB\Field(type="float")
     */
    private $amount;

    /**
     * @MongoDB\EmbedMany(targetDocument="App\Document\OrderLine")
     */
    private $lines;

    /**
     * @MongoDB\Field(type="string")
     */
    private $shipping_address;

    /**
     * @MongoDB\Field(type="string")
     */
    private $billing_addres;

    public function __construct()
    {
        $this->lines = new ArrayCollection();
    }

    public function toArray()
    {
        $arr = $this->getLines()->toArray();
        $linesArray = [];
        foreach($arr as $line)
        {
            $linesArray[] = $line->toArray();
        }

        return [
            'order_id' => $this->getOrderId(),
            'status' => (string) $this->getStatus(),
            'amount' => $this->getAmount(),
            'lines' => $linesArray,
            'shipping_address' => $this->getShippingAddress(),
            'billing_address' => $this->getBillingAddres()
        ];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * @param mixed $order_id
     */
    public function setOrderId($order_id): void
    {
        $this->order_id = $order_id;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * @param mixed $lines
     */
    public function addLine($lines): void
    {
        $this->lines->add($lines);
    }

    /**
     * @return mixed
     */
    public function getShippingAddress()
    {
        return $this->shipping_address;
    }

    /**
     * @param mixed $shipping_address
     */
    public function setShippingAddress($shipping_address): void
    {
        $this->shipping_address = $shipping_address;
    }

    /**
     * @return mixed
     */
    public function getBillingAddres()
    {
        return $this->billing_addres;
    }

    /**
     * @param mixed $billing_addres
     */
    public function setBillingAddres($billing_addres): void
    {
        $this->billing_addres = $billing_addres;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return new OrderStatusVO($this->status);
    }

    /**
     * @param mixed $status
     */
    public function setStatus(OrderStatusVO $status): void
    {
        $this->status = $status->getStatus();
    }
}