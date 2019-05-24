<?php

namespace App\Tests\Util;

use App\DTO\OrderLineDTO;
use PHPUnit\Framework\TestCase;

class OrderLineDTOTest extends TestCase
{
    /**
     * method __construct
     * when called
     * should createProperDTO
     */
    public function test__construct_called_createProperDTO()
    {
        $data = [
            'sku' => 'xx-43-xx',
            'price' => 2.3,
            'quantity' => 1,
        ];

        $sut = new OrderLineDTO($data);

        $this->assertEquals('xx-43-xx', $sut->getSku());
        $this->assertEquals(2.3, $sut->getPrice());
        $this->assertEquals(1, $sut->getQuantity());
    }

    /**
     * method toArray
     * when called
     * should returnArray
     */
    public function test_toArray_called_returnArray()
    {
        $data = [
            'sku' => 'xx-43-xx',
            'price' => 2.3,
            'quantity' => 1,
        ];

        $sut = new OrderLineDTO($data);

        $array = $sut->toArray();

        $this->assertArrayHasKey('sku', $array);
        $this->assertArrayHasKey('price', $array);
        $this->assertArrayHasKey('quantity', $array);
    }
}
