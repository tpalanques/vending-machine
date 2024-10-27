<?php

namespace app\Application\input\processor;

use app\Ports\In\change\Factory as ChangeFactory;
use app\Ports\In\coin\Coin as iCoin;
use app\Ports\In\coin\Factory as CoinFactory;
use app\Ports\In\coin\SetFactory as CoinSetFactory;
use app\Ports\In\coin\ValueServiceFactory;
use app\Ports\In\coin\Set as iCoinSet;
use app\Ports\In\machine\BuyServiceFactory;
use app\Ports\In\machine\BuyService as iBuyService;
use app\Ports\In\processor\Factory as ProcessorFactory;
use app\Ports\In\processor\Processor as iProcessor;
use app\Ports\In\product\Factory as ProductFactory;
use app\Ports\In\product\SetFactory;
use app\Ports\In\stock\Stock as iStock;
use app\Ports\In\stock\Factory as StockFactory;
use app\Ports\Out\input\Input as iInput;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase {

    private const float UNLIMITED_COIN_VALUE = 99999999;
    private const int UNLIMITED_STOCK = 999;

    private iCoinSet $credit;
    private iCoinSet $change;
    private iStock $juice;
    private iStock $soda;
    private iStock $water;
    private CoinFactory $coinFactory;
    private iBuyService $buyService;
    private ValueServiceFactory $valueServiceFactory;

    protected function setUp(): void {
        parent::setUp();
        $this->coinFactory = new CoinFactory();
        $coinSetFactory = new CoinSetFactory();
        $this->credit = $coinSetFactory->createEmpty();
        $this->change = $coinSetFactory->createEmpty();
        $this->buyService = $this->getBuyService();
        $this->createStocks();
    }

    #[DataProvider('addCoinStock')]
    public function testInsertCoin(int $option, float $change): void {
        $this->setUnlimitedStocks();
        $sut = $this->buildProcessor($option);
        $sut->process();
        $this->checkFinalState(
            $sut,
            $option,
            $change,
            self::UNLIMITED_STOCK,
            self::UNLIMITED_STOCK,
            self::UNLIMITED_STOCK
        );
    }

    public static function addCoinStock(): array {
        $value = (new ValueServiceFactory())->get();
        return [
            [1, $value->getFiveCent()],
            [2, $value->getTenCent()],
            [3, $value->getQuarter()],
            [4, $value->getOne()]
        ];
    }

    #[DataProvider('productToBuyAndStockDecrease')]
    public function testAddStock(int $option, int $juiceAdded, int $sodaAdded, int $waterAdded): void {
        $this->change->add($this->getUnlimitedCoin());
        $sut = $this->buildProcessor($option);
        $sut->process();
        $this->checkFinalState($sut, $option, self::UNLIMITED_COIN_VALUE, $juiceAdded, $sodaAdded, $waterAdded);
    }

    public static function productToBuyAndStockDecrease(): array {
        return [
            [5, 1, 0, 0],
            [6, 0, 1, 0],
            [7, 0, 0, 1],
        ];
    }

    public function testExit() {
        $option = 0;
        $this->change->add($this->getUnlimitedCoin());
        $this->setUnlimitedStocks();
        $sut = $this->buildProcessor($option);
        $sut->process();
        $this->checkFinalState($sut, $option, self::UNLIMITED_COIN_VALUE, self::UNLIMITED_STOCK, self::UNLIMITED_STOCK, self::UNLIMITED_STOCK);
    }

    private function checkFinalState(iProcessor $sut, string $option, float $change, int $juiceStock, int $sodaStock, int $waterStock): void {
        $this->assertEquals($change, $sut->getChange()->getValue());
        $this->assertEquals($option, $sut->getOption());
        $this->assertEquals($juiceStock, $this->juice->get());
        $this->assertEquals($sodaStock, $this->soda->get());
        $this->assertEquals($waterStock, $this->water->get());
    }

    private function getInputMock(string $input): iInput {
        $mock = $this->createMock(iInput::class);
        $mock->method('get')->willReturn($input);
        return $mock;
    }

    private function getBuyService(): iBuyService {
        $changeFactory = new ChangeFactory();
        $changeStrategy = $changeFactory->getKeepAll();
        $buyServiceFactory = new BuyServiceFactory($changeStrategy);
        return $buyServiceFactory->get();
    }

    private function createStocks(): void {
        $stockFactory = new StockFactory(new SetFactory());
        $productFactory = new ProductFactory();
        $this->juice = $stockFactory->create($productFactory->getJuice());
        $this->soda = $stockFactory->create($productFactory->getSoda());
        $this->water = $stockFactory->create($productFactory->getWater());
    }

    private function setUnlimitedStocks(): void {
        $this->juice->add(self::UNLIMITED_STOCK);
        $this->soda->add(self::UNLIMITED_STOCK);
        $this->water->add(self::UNLIMITED_STOCK);
    }

    private function buildProcessor(int $option): iProcessor {
        $processorFactory = new ProcessorFactory(
            $this->getInputMock($option),
            $this->credit,
            $this->change,
            $this->juice,
            $this->soda,
            $this->water,
            $this->coinFactory,
            $this->buyService
        );
        return $processorFactory->getService();
    }

    private function getUnlimitedCoin(): iCoin {
        $mock = $this->createMock(iCoin::class);
        $mock->method('getValue')->willReturn(self::UNLIMITED_COIN_VALUE);
        return $mock;
    }
}
