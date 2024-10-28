<?php

namespace app\Application\change;

use app\Ports\In\change\Factory as ChangeFactory;
use app\Ports\In\change\NotEnoughCash;
use app\Ports\In\change\Service;
use app\Ports\In\coin\OrderServiceFactory;
use app\Ports\In\coin\SetFactory as CoinSetFactory;
use app\Ports\In\coin\Factory as CoinFactory;
use PHPUnit\Framework\TestCase;

class SaveCreditTest extends TestCase {

    private const float PRICE = 1.50;

    private CoinFactory $coinFactory;
    private CoinSetFactory $coinSetFactory;
    private Service $sut;

    protected function setUp(): void {
        parent::setUp();
        $this->coinSetFactory = new CoinSetFactory();
        $this->coinFactory = new CoinFactory();
        $orderService = (new OrderServiceFactory($this->coinSetFactory))->get();
        $this->sut = (new ChangeFactory($orderService))->getSaveCredit();
    }

    public function testGetExactChange() {
        $coinSet = $this->coinSetFactory->create(
            $this->coinFactory->getOne(),
            $this->coinFactory->getQuarter(),
            $this->coinFactory->getQuarter()
        );
        $this->assertEquals(0, $this->sut->get($coinSet, self::PRICE, $this->coinSetFactory->createEmpty())->getValue());
    }

    public function testGetChangePayingExactly(): void {
        $coinSet = $this->coinSetFactory->create(
            $this->coinFactory->getFiveCent(),
            $this->coinFactory->getOne(),
            $this->coinFactory->getQuarter(),
            $this->coinFactory->getTenCent(),
            $this->coinFactory->getQuarter()
        );
        $this->assertEquals(0.15, $this->sut->get($coinSet, self::PRICE, $this->coinSetFactory->createEmpty())->getValue());
    }

    public function testGetChangePayingNotExactly(): void {
        $coinSet = $this->coinSetFactory->create(
            $this->coinFactory->getOne(),
            $this->coinFactory->getOne()
        );
        $this->assertEquals(2, $this->sut->get($coinSet, self::PRICE, $this->coinSetFactory->createEmpty())->getValue());
    }
}

