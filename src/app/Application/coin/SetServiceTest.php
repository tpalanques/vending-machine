<?php

namespace app\Application\coin;

use app\Ports\In\coin\Coin as iCoin;
use app\Ports\In\coin\Factory as CoinFactory;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use TypeError;

class SetServiceTest extends TestCase {

    private CoinFactory $coinFactory;
    private SetService $sut;

    protected function setUp(): void {
        parent::setUp();
        $this->sut = new SetService();
        $this->coinFactory = new CoinFactory();
    }

    #[DataProvider('singleCoins')]
    public function testAddSingleCoin(float $value, ?iCoin $coin): void {
        if ($coin) {
            $this->sut->add($coin);
        }
        $this->assertEquals($value, $this->sut->getValue());
    }

    public static function singleCoins(): array {
        $coinFactory = new CoinFactory();
        return [
            [0, null],
            [0.05, $coinFactory->getFiveCent()],
            [0.10, $coinFactory->getTenCent()],
            [0.25, $coinFactory->getQuarter()],
            [1, $coinFactory->getOne()],
        ];
    }

    #[DataProvider('multipleCoins')]
    public function testAddMultiple(float $value, iCoin ...$coins): void {
        foreach ($coins as $coin) {
            $this->sut->add($coin);
        }
        $this->assertEquals($value, $this->sut->getValue());
    }

    public static function multipleCoins(): array {
        $coinFactory = new CoinFactory();
        $fiveCent = $coinFactory->getFiveCent();
        $tenCent = $coinFactory->getTenCent();
        $quarter = $coinFactory->getQuarter();
        $one = $coinFactory->getOne();
        return [
            [0.10, $fiveCent, $fiveCent],
            [0.15, $fiveCent, $tenCent],
            [0.20, $tenCent, $tenCent],
            [0.25, $tenCent, $tenCent, $fiveCent],
            [0.30, $tenCent, $tenCent, $tenCent],
            [0.35, $tenCent, $quarter],
            [0.50, $quarter, $quarter],
            [2, $one, $one],
        ];
    }

    public function testCantAddNoCoin(): void {
        $this->expectException(TypeError::class);
        $this->sut->add(null);
    }

    public function testRemoveUnexistentOne(): void {
        $this->sut->remove($this->coinFactory->getOne());
        $this->assertEquals(0, $this->sut->getValue());
    }
}
