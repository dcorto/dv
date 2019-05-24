<?php

namespace App\Tests\Util;

use App\DTO\OrderDTO;
use App\VO\Enum\OrderStatusEnum;
use PHPUnit\Framework\TestCase;

class OrderDTOTest extends TestCase
{
    /**
     * method __construct
     * when called
     * should createProperDTO
     */
    public function test__construct_called_createProperDTO()
    {
        $data = [
            'order_id' => 1234,
            'status' => OrderStatusEnum::PENDING_CONFIRMATION,
            'amount' => 9.9,
            'lines' => [
                [
                    'sku' => 'xx-43-xx',
                    'price' => 2.3,
                    'quantity' => 1,
                ],
                [
                    'sku' => 'xx-40-xx',
                    'price' => 2.3,
                    'quantity' => 1,
                ]
            ],
            'shipping_address' => 'shipping address',
            'billing_address' => 'billing address',
        ];

        $sut = new OrderDTO($data);

        $this->assertEquals(1234, $sut->getOrderId());
        $this->assertEquals(9.9, $sut->getAmount());
        $this->assertEquals(OrderStatusEnum::PENDING_CONFIRMATION, $sut->getStatus());
        $this->assertNotEmpty($sut->getLines());
        $this->assertEquals('billing address', $sut->getBillingAddress());
        $this->assertEquals('shipping address', $sut->getShippingAddress());

    }

    /**
     * method toArray
     * when called
     * should returnArray
     */
    public function test_toArray_called_returnArray()
    {
        $data = [
            'order_id' => 1234,
            'status' => OrderStatusEnum::PENDING_CONFIRMATION,
            'amount' => 9.9,
            'lines' => [
                [
                    'sku' => 'xx-43-xx',
                    'price' => 2.3,
                    'quantity' => 1,
                ],
                [
                    'sku' => 'xx-40-xx',
                    'price' => 2.3,
                    'quantity' => 1,
                ]
            ],
            'shipping_address' => 'shipping address',
            'billing_address' => 'billing address',
        ];

        $sut = new OrderDTO($data);

        $array = $sut->toArray();

        $this->assertArrayHasKey('order_id', $array);
        $this->assertArrayHasKey('status', $array);
        $this->assertArrayHasKey('lines', $array);
    }
}
