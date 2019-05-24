<?php

namespace App\DTO;

class OrderLineDTO implements IDTO
{
    private $data;

    protected $sku;
    protected $price;
    protected $quantity;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->exchange();
    }

    public function exchange()
    {
        $this->sku = $this->data['sku'];
        $this->price = $this->data['price'];
        $this->quantity = $this->data['quantity'];
    }

    public function toArray()
    {
        return [
            'sku' => $this->sku,
            'price' => $this->price,
            'quantity' => $this->quantity,
        ];
    }

    /**
     * @return mixed
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}