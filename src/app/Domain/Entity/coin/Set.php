<?php

namespace app\Domain\Entity\coin;

use app\Ports\In\coin\Coin as iCoin;
use app\Ports\In\coin\Set as iSet;
use app\Config;

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
            $totalValue += round($coin->getValue(), $this->getPrecision());
        }
        return round($totalValue, $this->getPrecision());
    }

    public function empty(): array {
        $coins = $this->coins;
        $this->coins = [];
        return $coins;
    }

    private function getPrecision(): int {
        return Config::COIN_PRECISION;
    }
}
