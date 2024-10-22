<?php

namespace app\Application\coin;

class Supported {

    // TODO: move supported coins to repository
    private array $supported = [0.05, 0.10, 0.25, 1];

    public function isSupported(float $value): bool {
        return in_array($value, $this->supported);
    }
}
