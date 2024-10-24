<?php

namespace app\Domain\Entity\coin;

use app\Application\coin\ValueService;
use app\Ports\In\coin\Coin as iCoin;
use app\Ports\In\coin\UnsupportedValue;
use app\Config;

class Coin implements iCoin {

    private const int PRECISION = 2;

    private float $value;

    public function __construct(ValueService $valueService, float $value) {
        if (!$valueService->isSupported($value)) {
            throw new UnsupportedValue($value);
        }
        $this->value = round($value, $this->getPrecision());
    }

    public function getValue(): float {
        return round($this->value, $this->getPrecision());
    }

    private function getPrecision(): int {
        return Config::COIN_PRECISION;
    }
}
