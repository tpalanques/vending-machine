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

    #[DataProvider('singleCoinsAdded')]
    public function testAddSingleCoin(float $value, ?iCoin $coin): void {
        if ($coin) {
            $this->sut->add($coin);
        }
        $this->assertEquals($value, $this->sut->getValue());
    }

    public static function singleCoinsAdded(): array {
        $coinFactory = new CoinFactory();
        return [
            [0, null],
            [0.05, $coinFactory->getFiveCent()],
            [0.10, $coinFactory->getTenCent()],
            [0.25, $coinFactory->getQuarter()],
            [1, $coinFactory->getOne()],
        ];
    }

    #[DataProvider('multipleCoinsAdded')]
    public function testAddMultiple(float $value, iCoin ...$coins): void {
        foreach ($coins as $coin) {
            $this->sut->add($coin);
        }
        $this->assertEquals($value, $this->sut->getValue());
    }

    public static function multipleCoinsAdded(): array {
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
            [0.35, $quarter, $tenCent],
            [0.40, $quarter, $tenCent, $fiveCent],
            [0.45, $quarter, $tenCent, $tenCent],
            [0.50, $quarter, $quarter],
            [0.55, $quarter, $quarter, $fiveCent],
            [0.60, $quarter, $quarter, $tenCent],
            [0.65, $quarter, $quarter, $tenCent, $fiveCent],
            [0.70, $quarter, $quarter, $tenCent, $tenCent],
            [0.75, $quarter, $quarter, $quarter],
            [0.80, $quarter, $quarter, $quarter, $fiveCent],
            [0.85, $quarter, $quarter, $quarter, $tenCent],
            [0.90, $quarter, $quarter, $quarter, $tenCent, $fiveCent],
            [0.95, $quarter, $quarter, $quarter, $tenCent, $tenCent],
            [1.05, $one, $fiveCent],
            [1.10, $one, $tenCent],
            [1.15, $one, $tenCent, $fiveCent],
            [1.20, $one, $tenCent, $tenCent],
            [1.25, $one, $quarter],
            [1.30, $one, $quarter, $fiveCent],
            [1.35, $one, $quarter, $tenCent],
            [1.40, $one, $quarter, $tenCent, $fiveCent],
            [1.45, $one, $quarter, $tenCent, $tenCent],
            [1.50, $one, $quarter, $quarter],
            [1.55, $one, $quarter, $quarter, $fiveCent],
            [1.60, $one, $quarter, $quarter, $tenCent],
            [1.65, $one, $quarter, $quarter, $tenCent, $fiveCent],
            [1.70, $one, $quarter, $quarter, $tenCent, $tenCent],
            [1.75, $one, $quarter, $quarter, $quarter],
            [1.80, $one, $quarter, $quarter, $quarter, $fiveCent],
            [1.85, $one, $quarter, $quarter, $quarter, $tenCent],
            [1.90, $one, $quarter, $quarter, $quarter, $tenCent, $fiveCent],
            [1.95, $one, $quarter, $quarter, $quarter, $tenCent, $tenCent],
            [2, $one, $one],
        ];
    }

    public function testCantAddNoCoin(): void {
        $this->expectException(TypeError::class);
        $this->sut->add(null);
    }

    #[DataProvider('nonExistentCoinsRemoved')]
    public function testRemoveNonexistentCoin(iCoin $coin): void {
        $this->sut->remove($coin);
        $this->assertEquals(0, $this->sut->getValue());
    }

    public static function nonExistentCoinsRemoved(): array {
        $coinFactory = new CoinFactory();
        return [
            [$coinFactory->getFiveCent()],
            [$coinFactory->getTenCent()],
            [$coinFactory->getQuarter()],
            [$coinFactory->getOne()],
        ];
    }

    #[DataProvider('coinsRemoved')]
    public function testRemoveCoin(float $value, iCoin $coinToRemove, iCoin ...$coins): void {
        foreach ($coins as $coin) {
            $this->sut->add($coin);
        }
        $this->sut->remove($coinToRemove);
        $this->assertEquals($value, $this->sut->getValue());
    }

    public static function coinsRemoved(): array {
        $coinFactory = new CoinFactory();
        return [
            [0, $coinFactory->getFiveCent(), $coinFactory->getFiveCent()],
            [0.10, $coinFactory->getFiveCent(), $coinFactory->getFiveCent(), $coinFactory->getTenCent()],
            [0, $coinFactory->getTenCent(), $coinFactory->getTenCent()],
            [0.25, $coinFactory->getTenCent(), $coinFactory->getTenCent(), $coinFactory->getQuarter()],
            [0, $coinFactory->getQuarter(), $coinFactory->getQuarter()],
            [0.20, $coinFactory->getQuarter(), $coinFactory->getQuarter(), $coinFactory->getTenCent(), $coinFactory->getTenCent()],
            [0, $coinFactory->getOne(), $coinFactory->getOne()],
            [0.15, $coinFactory->getOne(), $coinFactory->getOne(), $coinFactory->getTenCent(), $coinFactory->getFiveCent()]
        ];
    }

}
