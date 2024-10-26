<?php

namespace app\Ports\In\stock;

use Exception;

class InsufficientStock extends Exception {
    public function __construct(int $amount, int $stock) {
        parent::__construct(
            "Can't remove " . $amount . ", ". $stock . " remaining"
        );
    }
}
