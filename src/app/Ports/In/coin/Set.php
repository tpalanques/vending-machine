<?php

namespace app\Ports\In\coin;

use app\Ports\In\coin\Coin as iCoin;

interface Set {
    public function add(iCoin $coin): void;

    public function remove(iCoin $coin): void;

    public function getValue(): float;

    public function empty(): void;

}
