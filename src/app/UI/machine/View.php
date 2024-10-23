<?php

namespace app\UI\machine;

use app\Ports\In\coin\Set as CoinSet;

class View {

    private CoinSet $insertedCoinSet;

    public function __construct(CoinSet $insertedCoinSet) {
        $this->insertedCoinSet = $insertedCoinSet;
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
            "\t 0) Leave" . PHP_EOL;
    }
}
