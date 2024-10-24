<?php

namespace app\Application\stock;

use app\Ports\In\product\Factory as ProductFactory;
use app\Ports\In\product\SetFactory;
use app\Ports\In\stock\Stock as iStock;
use app\Ports\In\stock\Factory as Factory;
use PHPUnit\Framework\TestCase;

class StockTest extends TestCase {

    private const int INITIAL_STOCK = 0;
    private const int STOCK_INCREASE = 5;
    private const int STOCK_DECREASE = 3;

    private iStock $sut;

    protected function setUp(): void {
        parent::setUp();
        $productFactory = new ProductFactory();
        $stockFactory = new Factory(new SetFactory());
        $this->sut = $stockFactory->create($productFactory->getJuice());
    }

    public function testInitialStock() {
        $this->assertEquals(self::INITIAL_STOCK, $this->sut->get());
        $this->assertFalse($this->sut->isAvailable());
    }

    public function testAdd() {
        $this->sut->add(self::STOCK_INCREASE);
        $this->assertEquals(self::INITIAL_STOCK + self::STOCK_INCREASE, $this->sut->get());
        $this->assertTrue($this->sut->isAvailable());
    }

    public function testRemove() {
        $finalStock = self::INITIAL_STOCK + self::STOCK_INCREASE - self::STOCK_DECREASE;
        $this->sut->add(self::STOCK_INCREASE);
        $this->sut->remove(self::STOCK_DECREASE);
        $this->assertEquals($finalStock, $this->sut->get());
        $this->assertTrue($this->sut->isAvailable());
    }
}
