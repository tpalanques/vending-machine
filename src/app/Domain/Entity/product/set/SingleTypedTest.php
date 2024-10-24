<?php

namespace app\Domain\Entity\product\set;

use app\Ports\In\product\SetFactory;
use app\Ports\In\product\SingleTypedSet as iSingleTypedSet;
use app\Ports\In\product\Factory as ProductFactory;
use app\Ports\In\product\SetFactory as Factory;
use PHPUnit\Framework\TestCase;

class SingleTypedTest extends TestCase {

    private iSingleTypedSet $sut;
    private ProductFactory $productFactory;

    protected function setUp(): void {
        parent::setUp();
        $this->productFactory = new ProductFactory();
        $this->sut = (new SetFactory())->createSingleTyped($this->productFactory->getJuice());
    }

    public function testCountWhenEmpty() {
        $this->assertEquals(0, $this->sut->count());
    }

    public function testGet() {
        $this->assertEquals($this->productFactory->getJuice(), $this->sut->getProduct());
    }

    public function testAdd() {
        $this->sut->add();
        $this->assertEquals(1, $this->sut->count());
    }

    public function testRemove() {
        $this->sut->add();
        $this->sut->remove();
        $this->assertEquals(0, $this->sut->count());
    }
}
