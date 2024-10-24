<?php

namespace app\Ports\In\change;

use app\Ports\In\coin\Set as iSet;
use Exception;

class NotEnoughCash extends Exception {
    public function __construct(iSet $coins, float $price) {
        parent::__construct(
            "Price " . $price . " can't be higher than the coins (" . $coins->getValue() . ")"
        );
    }
}
