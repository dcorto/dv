<?php

namespace App\DTO;

class OrderDTO implements IDTO
{
    private $data;

    protected $order_id;
    protected $status;
    protected $amount;
    protected $lines;
    protected $shipping_address;
    protected $billing_address;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->exchange();
    }

    public function exchange()
    {
        $this->order_id = $this->data['order_id'];
        $this->status = $this->data['status'];
        $this->amount = $this->data['amount'];
        $this->convertLinesToDTO($this->data['lines']);
        $this->shipping_address = $this->data['shipping_address'];
        $this->billing_address = $this->data['billing_address'];
    }

    public function toArray()
    {
        return [
            'order_id' => $this->order_id,
            'status' => $this->status,
            'amount' => $this->amount,
            'lines' => $this->convertLinesDTOtoArray(),
            'shipping_address' => $this->shipping_address,
            'billing_address' => $this->billing_address
        ];
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return mixed
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * @return mixed
     */
    public function getShippingAddress()
    {
        return $this->shipping_address;
    }

    /**
     * @return mixed
     */
    public function getBillingAddress()
    {
        return $this->billing_address;
    }
    private function convertLinesToDTO( array $lines )
    {
        foreach($lines as $line){
            $this->lines[] = new OrderLineDTO($line);
        }
    }

    private function convertLinesDTOtoArray()
    {
        $result = [];

        foreach($this->lines as $line){
            $result[] = $line->toArray();
        }

        return $result;
    }
}