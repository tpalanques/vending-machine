<?php

namespace app\UI\machine;

use app\Ports\In\coin\Set as iCoinSet;
use app\Ports\In\stock\Stock;
use app\Ports\Out\view\Console as iConsoleView;

class Service implements iConsoleView {

    private iCoinSet $change;
    private Stock $juice;
    private Stock $soda;
    private Stock $water;

    public function __construct(iCoinSet $change, Stock $juice, Stock $soda, Stock $water) {
        $this->change = $change;
        $this->juice = $juice;
        $this->soda = $soda;
        $this->water = $water;
    }

    public function render(): string {
        return $this->getTitle() . "\t\t\t\t\t\t\t\t" .
            $this->getChange() . PHP_EOL .
            $this->getMenu();
    }

    private function getTitle(): string {
        return "WELCOME TO SERVICE MODE!";
    }

    private function getChange(): string {
        return "[Change: " . $this->change->getValue() . " coins]";
    }

    private function getMenu(): string {
        return "Please select an option:" . PHP_EOL .
            "\t 1) Insert 0.05 coin" . PHP_EOL .
            "\t 2) Insert 0.10 coin" . PHP_EOL .
            "\t 3) Insert 0.25 coin" . PHP_EOL .
            "\t 4) Insert 1 coin" . PHP_EOL .
            "\t 5) Add juice stock (" . $this->juice->get() . ")" . PHP_EOL .
            "\t 6) Add juice soda (" . $this->soda->get() . ")" . PHP_EOL .
            "\t 7) Add juice water (" . $this->water->get() . ")" . PHP_EOL .
            "\t 0) Close service mode" . PHP_EOL;
    }
}
