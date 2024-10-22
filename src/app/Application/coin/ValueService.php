<?php

namespace app\Application\coin;

use app\Ports\In\coin\Value as iSupported;

class ValueService implements iSupported {

    // TODO: move supported coins to repository
    private const float FIVE_CENT = 0.05;
    private const float TEN_CENT = 0.10;
    private const float QUARTER = 0.25;
    private const float ONE = 1;

    public function isSupported(float $value): bool {
        return in_array($value, [self::FIVE_CENT, self::TEN_CENT, self::QUARTER, self::ONE]);
    }

    public function getFiveCent(): float {
        return self::FIVE_CENT;
    }

    public function getTenCent(): float {
        return self::TEN_CENT;
    }

    public function getQuarter(): float {
        return self::QUARTER;
    }

    public function getOne(): float {
        return self::ONE;
    }
}
