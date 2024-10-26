<?php

namespace app\Ports\Out\view;

use app\Ports\In\coin\Set as iCoinSet;
use app\Ports\In\stock\Stock;
use app\UI\machine\Main;
use app\Ports\Out\view\Console as iConsole;
use app\UI\machine\Service;

class Factory {

    private iCoinSet $credit;
    private iCoinSet $change;
    private Stock $juice;
    private Stock $soda;
    private Stock $water;

    public function __construct(iCoinSet $credit, iCoinSet $change,$juice, Stock $soda, Stock $water) {
        $this->credit = $credit;
        $this->change = $change;
        $this->juice = $juice;
        $this->soda = $soda;
        $this->water = $water;
    }

    public function getMain(): iConsole {
        return new Main($this->credit, $this->juice, $this->soda, $this->water);
    }

    public function getService(): iConsole {
        return new Service($this->change, $this->juice, $this->soda, $this->water);
    }
}
