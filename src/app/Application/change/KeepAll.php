<?php

namespace app\Application\change;

use app\Ports\In\change\Service as iService;
use app\Ports\In\change\NotEnoughCash;
use app\Ports\In\coin\Set as iCoinSet;

class KeepAll implements iService {
    public function get(iCoinSet $credit, float $price, iCoinSet $change): iCoinSet {
        $credit->empty();
        return $credit;
    }
}
