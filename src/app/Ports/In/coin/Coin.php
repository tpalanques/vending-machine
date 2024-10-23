<?php

namespace app\Ports\In\coin;

interface Coin {
    public function getValue(): float;
    public static function getPrecision(): int;
}
