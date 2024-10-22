<?php

namespace app\Ports\In\coin;

interface Value {
    public function isSupported(float $value): bool;
}
