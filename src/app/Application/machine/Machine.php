<?php

namespace app\Application\machine;

use app\Ports\In\coin\Factory as CoinFactory;
use app\Ports\In\coin\Set as CoinSet;
use app\Ports\In\machine\BuyService as iBuyService;
use app\Ports\In\machine\NotEnoughCash;
use app\Ports\In\product\Factory as ProductFactory;
use app\Ports\In\stock\Factory as StockFactory;
use app\Ports\In\stock\InsufficientStock;
use app\Ports\In\stock\Stock as iStock;
use app\Ports\Out\input\Input as iInput;
use app\Ports\Out\view\Factory as ViewFactory;

class Machine {

    private const int JUICE_STARTING_STOCK = 3;
    private const int SODA_STARTING_STOCK = 5;
    private const int WATER_STARTING_STOCK = 1;
    const int AMOUNT = 1;

    private iBuyService $buyService;
    private CoinFactory $coinFactory;
    private CoinSet $insertedCoinSet;
    private iInput $input;
    private iStock $juice;
    private iStock $soda;
    private iStock $water;
    private ProductFactory $productFactory;
    private ViewFactory $viewFactory;

    public function __construct(
        iBuyService    $buyService,
        CoinFactory    $coinFactory,
        iInput         $input,
        ProductFactory $productFactory,
        CoinSet        $insertedCoinSet,
        StockFactory   $stockFactory,
        ViewFactory    $viewFactory
    ) {
        $this->buyService = $buyService;
        $this->coinFactory = $coinFactory;
        $this->input = $input;
        $this->productFactory = $productFactory;
        $this->insertedCoinSet = $insertedCoinSet;
        $this->viewFactory = $viewFactory;
        $this->buildProductStocks($stockFactory, $this->productFactory);
        $this->refillStocks();
    }

    public function run(): void {
        while (true) {
            echo $this->viewFactory->getMain($this->insertedCoinSet, $this->juice, $this->soda, $this->water)->render();
            $this->processInput($this->input);
        }
    }

    private function processInput(iInput $input): void {
        switch ($input->get()) {
            case "1":
                $this->insertedCoinSet->add($this->coinFactory->getFiveCent());
                return;
            case "2":
                $this->insertedCoinSet->add($this->coinFactory->getTenCent());
                return;
            case "3":
                $this->insertedCoinSet->add($this->coinFactory->getQuarter());
                return;
            case "4":
                $this->insertedCoinSet->add($this->coinFactory->getOne());
                return;
            case "5":
                $this->buy($this->juice, self::AMOUNT);
                return;
            case "6":
                $this->buy($this->soda, self::AMOUNT);
                return;
            case "7":
                $this->buy($this->water, self::AMOUNT);
                return;
            case "0":
                $refundedCoins = $this->insertedCoinSet->empty();
                foreach ($refundedCoins as $coin) {
                    echo "Here's your: " . $coin->getValue() . " coin" . PHP_EOL;
                }
                exit;
            default:
                echo "Invalid option" . PHP_EOL;
        }
    }

    private function buy(iStock $stock, int $amount): void {
        try {
            $stock->remove($amount);
            $this->buyService->buy($stock->getProduct(), $this->insertedCoinSet);
        } catch (NotEnoughCash|InsufficientStock $exception) {
            echo $exception->getMessage() . PHP_EOL;
        }
    }

    private function buildProductStocks(StockFactory $stockFactory, ProductFactory $productFactory): void {
        $this->juice = $stockFactory->create($productFactory->getJuice());
        $this->soda = $stockFactory->create($productFactory->getSoda());
        $this->water = $stockFactory->create($productFactory->getWater());
    }

    private function refillStocks(): void {
        $this->juice->add(self::JUICE_STARTING_STOCK);
        $this->soda->add(self::SODA_STARTING_STOCK);
        $this->water->add(self::WATER_STARTING_STOCK);
    }
}
