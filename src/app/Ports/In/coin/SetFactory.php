<?php

namespace app\Ports\In\coin;

use app\Ports\In\coin\Coin as iCoin;
use app\Domain\Entity\coin\Set;
use app\Ports\In\coin\Set as iSet;

class SetFactory {

    public function createEmpty(): iSet {
        return new Set();
    }

    public function create(iCoin ...$coins): iSet {
        $set = new Set();
        foreach ($coins as $coin) {
            $set->add($coin);
        }
        return $set;
    }
}
