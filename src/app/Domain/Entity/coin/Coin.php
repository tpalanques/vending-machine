<?php

namespace app\Domain\Entity\coin;

use app\Application\coin\ValueService;
use app\Ports\In\coin\Coin as iCoin;
use app\Ports\In\coin\UnsupportedValue;

class Coin implements iCoin {

    private float $value;

    public function __construct(ValueService $valueService, float $value) {
        if (!$valueService->isSupported($value)) {
            throw new UnsupportedValue($value);
        }
        $this->value = $value;
    }

    public function getValue(): float {
        return $this->value;
    }
}
