<?php

namespace app\Ports\In\coin;

interface ValueService {
    public function isSupported(float $value): bool;
}
