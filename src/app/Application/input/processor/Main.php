<?php

namespace app\Application\input\processor;

use app\Application\machine\BuyService;
use app\Ports\In\coin\Factory as CoinFactory;
use app\Ports\In\coin\Set as CoinSet;
use app\Ports\In\processor\Processor as iProcessor;
use app\Ports\In\machine\BuyService as iBuyService;
use app\Ports\In\machine\NotEnoughCash;
use app\Ports\In\stock\InsufficientStock;
use app\Ports\In\stock\Stock as iStock;
use app\Ports\Out\input\Input as iInput;

class Main implements iProcessor {

    private const int AMOUNT = 1;

    private iInput $input;
    private CoinSet $insertedCoinSet;
    private iStock $juice;
    private iStock $soda;
    private iStock $water;
    private CoinFactory $coinFactory;
    private BuyService $buyService;

    public function __construct(
        iInput      $input,
        CoinSet     $insertedCoinSet,
        iStock      $juice,
        iStock      $soda,
        iStock      $water,
        CoinFactory $coinFactory,
        iBuyService $buyService
    ) {
        $this->input = $input;
        $this->insertedCoinSet = $insertedCoinSet;
        $this->juice = $juice;
        $this->soda = $soda;
        $this->water = $water;
        $this->coinFactory = $coinFactory;
        $this->buyService = $buyService;
    }

    public
    function process(): void {
        switch ($this->input->get()) {
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
                $this->buy($this->juice);
                return;
            case "6":
                $this->buy($this->soda);
                return;
            case "7":
                $this->buy($this->water);
                return;
            case "8":
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

    private function buy(iStock $stock): void {
        try {
            $stock->remove(self::AMOUNT);
            $this->buyService->buy($stock->getProduct(), $this->insertedCoinSet);
        } catch (NotEnoughCash|InsufficientStock $exception) {
            echo $exception->getMessage() . PHP_EOL;
        }
    }
}
