<?php

namespace app\Application\change;

use app\Ports\In\change\NotEnoughCash;
use app\Ports\In\coin\SetFactory as CoinSetFactory;
use app\Ports\In\coin\Factory as CoinFactory;
use PHPUnit\Framework\TestCase;

class KeepAllTest extends TestCase {

    private const float PRICE = 1.24;
    private const float WRONG_PRICE = 1.64;

    private CoinFactory $coinFactory;
    private CoinSetFactory $coinSetFactory;
    private KeepAll $sut;

    protected function setUp(): void {
        parent::setUp();
        $this->coinSetFactory = new CoinSetFactory();
        $this->coinFactory = new CoinFactory();
        $this->sut = new KeepAll();
    }

    public function testGetChange(): void {
        $coinSet = $this->coinSetFactory->create(
            $this->coinFactory->getOne(),
            $this->coinFactory->getQuarter(),
            $this->coinFactory->getTenCent(),
            $this->coinFactory->getFiveCent()
        );
        $this->assertEquals(0, $this->sut->get($coinSet, self::PRICE)->getValue());
    }

    public function testCantGetChange(): void {
        $coinSet = $this->coinSetFactory->create(
            $this->coinFactory->getOne(),
            $this->coinFactory->getQuarter(),
            $this->coinFactory->getTenCent(),
            $this->coinFactory->getFiveCent()
        );
        $this->expectException(NotEnoughCash::class);
        $this->sut->get($coinSet, self::WRONG_PRICE);
    }

}
