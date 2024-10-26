<?php

namespace app\Application\input\processor;

use app\Ports\In\coin\Factory as CoinFactory;
use app\Ports\In\coin\Set as iCoinSet;
use app\Ports\In\processor\Processor as iProcessor;
use app\Ports\In\machine\BuyService as iBuyService;
use app\Ports\In\machine\NotEnoughCash;
use app\Ports\In\stock\InsufficientStock;
use app\Ports\In\stock\Stock as iStock;
use app\Ports\Out\input\Input as iInput;

class Main implements iProcessor {

    private const int AMOUNT = 1;

    private iInput $input;
    private iCoinSet $credit;
    private iStock $juice;
    private iStock $soda;
    private iStock $water;
    private CoinFactory $coinFactory;
    private iBuyService $buyService;
    private ?string $option;

    public function __construct(
        iInput      $input,
        iCoinSet    $credit,
        iStock      $juice,
        iStock      $soda,
        iStock      $water,
        CoinFactory $coinFactory,
        iBuyService $buyService
    ) {
        $this->input = $input;
        $this->credit = $credit;
        $this->juice = $juice;
        $this->soda = $soda;
        $this->water = $water;
        $this->coinFactory = $coinFactory;
        $this->buyService = $buyService;
        $this->option = null;
    }

    public function process(): void {
        $this->option = $this->input->get();
        switch ($this->option) {
            case "1":
                $this->credit->add($this->coinFactory->getFiveCent());
                return;
            case "2":
                $this->credit->add($this->coinFactory->getTenCent());
                return;
            case "3":
                $this->credit->add($this->coinFactory->getQuarter());
                return;
            case "4":
                $this->credit->add($this->coinFactory->getOne());
                return;
            case "5":
                $this->credit = $this->buy($this->juice);
                return;
            case "6":
                $this->credit = $this->buy($this->soda);
                return;
            case "7":
                $this->credit = $this->buy($this->water);
                return;
            case "8":
                return;
            case "0":
                $refundedCoins = $this->credit->empty();
                foreach ($refundedCoins as $coin) {
                    echo "Here's your: " . $coin->getValue() . " coin" . PHP_EOL;
                }
                exit;
            default:
                echo "Invalid option" . PHP_EOL;
        }
    }

    public function getCredit(): iCoinSet {
        return $this->credit;
    }

    // TODO unit thest this method
    public function getOption(): string {
        return $this->option;
    }

    private function buy(iStock $stock): iCoinSet {
        $initialCash = clone $this->credit;
        try {
            $cashBack = $this->buyService->buy($stock->getProduct(), $this->credit);
            $stock->remove(self::AMOUNT);
            echo "Here's your product! -> " . $stock->getProduct()->getName() . PHP_EOL;
            return $cashBack;
        } catch (NotEnoughCash|InsufficientStock $exception) {
            echo $exception->getMessage() . PHP_EOL;
            return $initialCash;
        }
    }
}