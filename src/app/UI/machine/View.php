<?php

namespace app\UI\machine;

use app\Ports\In\coin\Set as CoinSet;
use app\Ports\In\stock\Stock;

class View {

    private CoinSet $insertedCoinSet;
    private Stock $juice;
    private Stock $soda;
    private Stock $water;

    public function __construct(CoinSet $insertedCoinSet, Stock $juice, Stock $soda, Stock $water) {
        $this->insertedCoinSet = $insertedCoinSet;
        $this->juice = $juice;
        $this->soda = $soda;
        $this->water = $water;
    }

    public function render(): string {
        return $this->getTitle() . "\t\t\t\t\t\t\t\t" .
            $this->getCredit() . PHP_EOL .
            $this->getMenu();
    }

    private function getTitle(): string {
        return "WELCOME TO THE VENDING MACHINE!";
    }

    private function getCredit(): string {
        return "[Credit: " . $this->insertedCoinSet->getValue() . " coins]";
    }

    private function getMenu(): string {
        return "Please select an option:" . PHP_EOL .
            "\t 1) Insert 0.05 coin" . PHP_EOL .
            "\t 2) Insert 0.10 coin" . PHP_EOL .
            "\t 3) Insert 0.25 coin" . PHP_EOL .
            "\t 4) Insert 1 coin" . PHP_EOL .
            "\t 5) Buy Juice" . $this->getUnitsLeft($this->juice) . PHP_EOL .
            "\t 6) Buy Soda" . $this->getUnitsLeft($this->soda) . PHP_EOL .
            "\t 7) Buy Water" . $this->getUnitsLeft($this->water) . PHP_EOL .
            "\t 0) Leave" . PHP_EOL;
    }

    private function getUnitsLeft(Stock $stock): string {
        return " ( " . $stock->get() . " units left )";
    }
}
