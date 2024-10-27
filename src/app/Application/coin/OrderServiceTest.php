<?php

namespace app\Application\coin;

use app\Ports\In\coin\Coin as iCoin;
use app\Ports\In\coin\Factory as CoinFactory;
use app\Ports\In\coin\OrderService as iOrderService;
use app\Ports\In\coin\OrderServiceFactory;
use app\Ports\In\coin\Set as iSet;
use app\Ports\In\coin\SetFactory;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class OrderServiceTest extends TestCase {

    private CoinFactory $coinFactory;
    private iSet $coinSet;
    private iOrderService $sut;

    protected function setUp(): void {
        parent::setUp();
        $this->coinFactory = new CoinFactory();
        $this->coinSet = (new SetFactory())->createEmpty();
        $this->sut = (new OrderServiceFactory(new SetFactory()))->get();
    }

    #[DataProvider('noOrderNeeded')]
    public function testNoOrderNeeded(iCoin ...$coins) {
        foreach ($coins as $coin) {
            $this->coinSet->add($coin);
        }
        $orderedCoinSet = $this->sut->order($this->coinSet);
        $this->assertEquals(
            $this->coinSet->getCoinsAsArray(),
            $orderedCoinSet->getCoinsAsArray()
        );
    }

    public static function noOrderNeeded(): array {
        $coinFactory = new CoinFactory();
        return [
            [],
            [$coinFactory->getOne(), $coinFactory->getQuarter(), $coinFactory->getTenCent(), $coinFactory->getFiveCent()],
            [$coinFactory->getOne(), $coinFactory->getOne(), $coinFactory->getTenCent(), $coinFactory->getFiveCent()],
            [$coinFactory->getOne(), $coinFactory->getQuarter(), $coinFactory->getQuarter()],
            [$coinFactory->getTenCent(), $coinFactory->getTenCent(), $coinFactory->getFiveCent()],
            [$coinFactory->getQuarter(), $coinFactory->getFiveCent(), $coinFactory->getFiveCent()],
        ];
    }

    #[DataProvider('orderNeeded')]
    public function testOrder(iCoin ...$coins) {
        foreach ($coins as $coin) {
            $this->coinSet->add($coin);
        }
        $orderedCoinSet = $this->sut->order($this->coinSet);
        $coinSetArray = $orderedCoinSet->getCoinsAsArray();
        $lastValue = $coinSetArray[0]->getValue();
        var_dump($coinSetArray);
        foreach ($coinSetArray as $coinSet) {
            $this->assertTrue($lastValue >= $coinSet->getValue());
            $lastValue = $coinSet->getValue();
        }
    }

    public static function orderNeeded(): array {
        $coinFactory = new CoinFactory();
        return [
            [$coinFactory->getFiveCent(), $coinFactory->getTenCent()],
            [$coinFactory->getTenCent(), $coinFactory->getQuarter()],
            [$coinFactory->getQuarter(), $coinFactory->getOne()],
            [$coinFactory->getFiveCent(), $coinFactory->getTenCent(), $coinFactory->getQuarter(), $coinFactory->getOne()]
        ];
    }
}
