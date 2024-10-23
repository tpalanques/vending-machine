<?php

namespace app\Application\machine;

use app\Ports\In\change\Factory as ChangeFactory;
use app\Ports\In\coin\Factory as CoinFactory;
use app\Ports\In\coin\Set as CoinSet;
use app\Ports\In\coin\SetFactory as CoinSetFactory;
use app\Ports\In\machine\BuyServiceFactory;
use app\Ports\In\machine\BuyService as iBuyService;
use app\Ports\In\machine\NotEnoughCash;
use app\Ports\In\product\Product as iProduct;
use app\Ports\In\product\Factory as ProductFactory;
use app\UI\machine\View;

class Machine {

    private iBuyService $buyService;
    private CoinFactory $coinFactory;
    private CoinSet $insertedCoinSet;
    private ProductFactory $productFactory;

    public function __construct() {
        $this->buyService = $this->getBuyService();
        $this->coinFactory = new CoinFactory();
        $this->insertedCoinSet = (new CoinSetFactory())->createEmpty();
        $this->productFactory = new ProductFactory();
    }

    public function run(): void {
        while (true) {
            echo $this->getView($this->insertedCoinSet)->render();
            $this->processAnswer($this->getAnswer());
        }
    }

    public function getView(CoinSet $insertedCoinSet): View {
        return new View($insertedCoinSet);
    }

    private function getAnswer(): string {
        $handle = fopen("php://stdin", "r");
        $line = fgets($handle);
        fclose($handle);
        return $line;
    }

    private function processAnswer(string $answer): void {
        switch ($answer) {
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
                $this->buy($this->productFactory->getJuice());
                return;
            case "6":
                $this->buy($this->productFactory->getSoda());
                return;
            case "7":
                $this->buy($this->productFactory->getWater());
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

    private function buy(iProduct $product): void {
        try {
            $this->buyService->buy($product, $this->insertedCoinSet);
        } catch (NotEnoughCash $exception) {
            echo $exception->getMessage() . PHP_EOL;
        }
    }

    private function getBuyService(): iBuyService {
        $changeStrategyFactory = new ChangeFactory();
        $changeStrategy = $changeStrategyFactory->getKeepAll();
        $buyServiceFactory = new BuyServiceFactory($changeStrategy);
        return $buyServiceFactory->get();
    }
}
