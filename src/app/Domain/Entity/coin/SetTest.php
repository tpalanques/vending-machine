<?php

namespace app\Domain\Entity\coin;

use app\Ports\In\coin\Coin as iCoin;
use app\Ports\In\coin\Factory as CoinFactory;
use app\Ports\In\coin\SetFactory;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use TypeError;

class SetTest extends TestCase {

    private Set $sut;

    protected function setUp(): void {
        parent::setUp();
        $this->sut = (new SetFactory())->createEmpty();
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

    #[DataProvider('setFiller')]
    public function testFilledSet(float $value, Set $sut): void {
        $this->assertEquals($value, $sut->getValue());
    }

    public static function setFiller(): array {
        $coinFactory = new CoinFactory();
        $setFactory = new SetFactory();
        $fiveCent = $coinFactory->getFiveCent();
        $tenCent = $coinFactory->getTenCent();
        $quarter = $coinFactory->getQuarter();
        $one = $coinFactory->getOne();
        return [
            [0.10, $setFactory->create($fiveCent, $fiveCent)],
            [0.15, $setFactory->create($fiveCent, $tenCent)],
            [0.20, $setFactory->create($tenCent, $tenCent)],
            [0.25, $setFactory->create($tenCent, $tenCent, $fiveCent)],
            [0.30, $setFactory->create($tenCent, $tenCent, $tenCent)],
            [0.35, $setFactory->create($quarter, $tenCent)],
            [0.40, $setFactory->create($quarter, $tenCent, $fiveCent)],
            [0.45, $setFactory->create($quarter, $tenCent, $tenCent)],
            [0.50, $setFactory->create($quarter, $quarter)],
            [0.55, $setFactory->create($quarter, $quarter, $fiveCent)],
            [0.60, $setFactory->create($quarter, $quarter, $tenCent)],
            [0.65, $setFactory->create($quarter, $quarter, $tenCent, $fiveCent)],
            [0.70, $setFactory->create($quarter, $quarter, $tenCent, $tenCent)],
            [0.75, $setFactory->create($quarter, $quarter, $quarter)],
            [0.80, $setFactory->create($quarter, $quarter, $quarter, $fiveCent)],
            [0.85, $setFactory->create($quarter, $quarter, $quarter, $tenCent)],
            [0.90, $setFactory->create($quarter, $quarter, $quarter, $tenCent, $fiveCent)],
            [0.95, $setFactory->create($quarter, $quarter, $quarter, $tenCent, $tenCent)],
            [1.10, $setFactory->create($one, $tenCent)],
            [1.15, $setFactory->create($one, $tenCent, $fiveCent)],
            [1.20, $setFactory->create($one, $tenCent, $tenCent)],
            [1.25, $setFactory->create($one, $quarter)],
            [1.30, $setFactory->create($one, $quarter, $fiveCent)],
            [1.35, $setFactory->create($one, $quarter, $tenCent)],
            [1.40, $setFactory->create($one, $quarter, $tenCent, $fiveCent)],
            [1.45, $setFactory->create($one, $quarter, $tenCent, $tenCent)],
            [1.50, $setFactory->create($one, $quarter, $quarter)],
            [1.55, $setFactory->create($one, $quarter, $quarter, $fiveCent)],
            [1.60, $setFactory->create($one, $quarter, $quarter, $tenCent)],
            [1.65, $setFactory->create($one, $quarter, $quarter, $tenCent, $fiveCent)],
            [1.70, $setFactory->create($one, $quarter, $quarter, $tenCent, $tenCent)],
            [1.75, $setFactory->create($one, $quarter, $quarter, $quarter)],
            [1.80, $setFactory->create($one, $quarter, $quarter, $quarter, $fiveCent)],
            [1.85, $setFactory->create($one, $quarter, $quarter, $quarter, $tenCent)],
            [1.90, $setFactory->create($one, $quarter, $quarter, $quarter, $tenCent, $fiveCent)],
            [1.95, $setFactory->create($one, $quarter, $quarter, $quarter, $tenCent, $tenCent)],
            [2, $setFactory->create($one, $one)],
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
    public function testRemoveCoinFromSet(float $value, iCoin $coinToRemove, Set $sut): void {
        $sut->remove($coinToRemove);
        $this->assertEquals($value, $sut->getValue());
    }

    public static function coinsRemoved(): array {
        $coinFactory = new CoinFactory();
        $setFactory = new SetFactory();
        $fiveCent = $coinFactory->getFiveCent();
        $tenCent = $coinFactory->getTenCent();
        $quarter = $coinFactory->getQuarter();
        $one = $coinFactory->getOne();
        return [
            [0, $fiveCent, $setFactory->create($fiveCent)],
            [0.10, $fiveCent, $setFactory->create($fiveCent, $tenCent)],
            [0, $tenCent, $setFactory->create($tenCent)],
            [0.25, $tenCent, $setFactory->create($tenCent, $quarter)],
            [0, $quarter, $setFactory->create($quarter)],
            [0.20, $quarter, $setFactory->create($quarter, $tenCent, $tenCent)],
            [0, $one, $setFactory->create($one)],
            [0.15, $one, $setFactory->create($one, $tenCent, $fiveCent)]
        ];
    }

}
