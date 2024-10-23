<?php

namespace app\Application\machine;

use app\Ports\In\coin\Coin as iCoin;
use app\Ports\In\coin\Set as iCoinSet;
use app\Ports\In\coin\SetFactory as coinSetFactory;
use app\Ports\In\change\Factory as ChangeFactory;
use app\Ports\In\machine\BuyService as iBuyService;
use app\Ports\In\machine\BuyServiceFactory;
use app\Ports\In\machine\NotEnoughCash;
use app\Ports\In\product\Product as iProduct;
use PHPUnit\Framework\TestCase;

class BuyServiceTest extends TestCase {

    private const string PRODUCT_NAME = "Test product";
    private const float PRODUCT_PRICE = 7.8;
    private const float CHANGE = 3.6;

    private iBuyService $sut;
    private coinSetFactory $coinSetFactory;

    protected function setUp(): void {
        parent::setUp();
        $this->coinSetFactory = new CoinSetFactory();
        $this->sut = $this->buildBuyService();
    }

    public function testBuy(): void {
        $product = $this->getProductMock();
        $coinSet = $this->getCoinSet(self::PRODUCT_PRICE + self::CHANGE);
        $change = $this->sut->buy($product, $coinSet);
        $this->assertEquals(0, $change->getValue());
    }

    public function testCantBuy(): void {
        $product = $this->getProductMock();
        $coinSet = $this->getCoinSet(self::PRODUCT_PRICE - self::CHANGE);
        $this->expectException(NotEnoughCash::class);
        $change = $this->sut->buy($product, $coinSet);
    }

    private function getCoinSet(float $value): iCoinSet {
        return $this->coinSetFactory->create(
            $this->getCoinMock($value)
        );
    }

    private function getCoinMock(float $value): iCoin {
        $mock = $this->createMock(iCoin::class);
        $mock->method('getValue')->willReturn($value);
        return $mock;
    }

    private function getProductMock() {
        $mock = $this->createMock(iProduct::class);
        $mock->method('getName')->willReturn(self::PRODUCT_NAME);
        $mock->method('getPrice')->willReturn(self::PRODUCT_PRICE);
        return $mock;
    }

    private function buildBuyService(): iBuyService {
        $changeFactory = new ChangeFactory();
        $keepAllStrategy = $changeFactory->getKeepAll();
        $buyServiceFactory = new BuyServiceFactory($keepAllStrategy);
        return $buyServiceFactory->get();
    }

}
