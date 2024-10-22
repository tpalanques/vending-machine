<?php

namespace app\Ports\In\coin;

use Exception;

class UnsupportedValue extends Exception {
    public function __construct(float $value) {
        parent::__construct('Coin value: ' . $value . ' is not supported.');
    }
}
