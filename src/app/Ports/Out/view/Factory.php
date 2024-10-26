<?php

namespace app\Ports\Out\view;

use app\Ports\In\coin\Set as CoinSet;
use app\Ports\In\stock\Stock;
use app\UI\machine\Main;
use app\Ports\Out\view\Console as iConsole;
use app\UI\machine\Service;

class Factory {

    public function getMain(CoinSet $insertedCoinSet, Stock $juice, Stock $soda, Stock $water): iConsole {
        return new Main($insertedCoinSet, $juice, $soda, $water);
    }

    public function getService(Stock $juice, Stock $soda, Stock $water): iConsole {
        return new Service($juice, $soda, $water);
    }
}
