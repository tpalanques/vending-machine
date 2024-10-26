<?php

namespace app\UI\machine;

use app\Ports\In\coin\Set as CoinSet;
use app\Ports\In\stock\Stock;
use app\Ports\Out\view\Console as iConsoleView;

class Service implements iConsoleView {

    public function __construct() {
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
            "\t 0) Leave" . PHP_EOL;
    }
}
