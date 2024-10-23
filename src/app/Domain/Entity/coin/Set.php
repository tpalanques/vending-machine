<?php

namespace app\Domain\Entity\coin;

use app\Ports\In\coin\Coin as iCoin;
use app\Ports\In\coin\Set as iSet;

class Set implements iSet {
    private array $coins = [];

    public function add(iCoin $coin): void {
        $this->coins[] = $coin;
    }

    public function remove(iCoin $coin): void {
        $index = null;
        foreach ($this->coins as $coinIndex => $currentCoin) {
            if ($currentCoin->getValue() === $coin->getValue()) {
                $index = $coinIndex;
            }
        }
        array_splice($this->coins, $index, 1);
    }

    public function getValue(): float {
        $totalValue = 0;
        foreach ($this->coins as $coin) {
            $totalValue += round($coin->getValue(), $coin->getPrecision());
        }
        return round($totalValue, Coin::getPrecision());
    }
}
