<?php

namespace app\UI\machine;

use app\Ports\In\stock\Stock;
use app\Ports\Out\view\Console as iConsoleView;

class Service implements iConsoleView {

    private Stock $juice;
    private Stock $soda;
    private Stock $water;

    public function __construct(Stock $juice, Stock $soda, Stock $water) {
        $this->juice = $juice;
        $this->soda = $soda;
        $this->water = $water;
    }

    public function render(): string {
        return $this->getTitle() . PHP_EOL .
            $this->getMenu();
    }

    private function getTitle(): string {
        return "WELCOME TO SERVICE MODE!";
    }

    private function getMenu(): string {
        return "Please select an option:" . PHP_EOL .
            "\t 1) Add juice stock (" . $this->juice->get() . ")" . PHP_EOL .
            "\t 2) Add juice soda (" . $this->soda->get() . ")" . PHP_EOL .
            "\t 3) Add juice water (" . $this->water->get() . ")" . PHP_EOL .
            "\t 0) Leave" . PHP_EOL;
    }
}
