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
    private iCoinSet $change;
    private iStock $juice;
    private iStock $soda;
    private iStock $water;
    private CoinFactory $coinFactory;
    private iBuyService $buyService;

    public function __construct(
        iInput      $input,
        iCoinSet    $credit,
        iCoinSet    $change,
        iStock      $juice,
        iStock      $soda,
        iStock      $water,
        CoinFactory $coinFactory,
        iBuyService $buyService
    ) {
        $this->input = $input;
        $this->credit = $credit;
        $this->change = $change;
        $this->juice = $juice;
        $this->soda = $soda;
        $this->water = $water;
        $this->coinFactory = $coinFactory;
        $this->buyService = $buyService;
    }

    public function process(): void {
        $this->input->wait();
        switch ($this->input->get()) {
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
                return;
            default:
                echo "Invalid option" . PHP_EOL;
        }
    }

    public function getCredit(): iCoinSet {
        return $this->credit;
    }

    public function getOption(): string {
        return $this->input->get();
    }

    private function buy(iStock $stock): iCoinSet {
        $initialCash = clone $this->credit;
        try {
            $cashBack = $this->buyService->buy($stock->getProduct(), $this->credit);
            $stock->remove(self::AMOUNT);
            // TODO: vaig per aqui, estic afegint els diners guanyats al stock de canvi
            foreach ($initialCash->empty() as $coin) {
                $this->change->add($coin);
            }
            echo "Here's your product! -> " . $stock->getProduct()->getName() . PHP_EOL;
            return $cashBack;
        } catch (NotEnoughCash|InsufficientStock $exception) {
            echo $exception->getMessage() . PHP_EOL;
            return $initialCash;
        }
    }
}
