<?php

namespace app\Domain\Entity\product\set;

use app\Ports\In\product\SetFactory;
use app\Ports\In\product\SingleTypedSet as iSingleTypedSet;
use app\Ports\In\product\Factory as ProductFactory;
use app\Ports\In\product\SetFactory as Factory;
use PHPUnit\Framework\TestCase;

class SingleTypedTest extends TestCase {

    private iSingleTypedSet $sut;

    protected function setUp(): void {
        parent::setUp();
        $productFactory = new ProductFactory();
        $this->sut = (new SetFactory())->createSingleTyped($productFactory->getJuice());
    }

    public function testCountWhenEmpty() {
        $this->assertEquals(0, $this->sut->count());
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
