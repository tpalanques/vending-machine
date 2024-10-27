<?php

namespace app\Application\coin;

use app\Ports\In\coin\OrderService;
use app\Ports\In\coin\Coin as iCoin;
use app\Ports\In\coin\Set;
use app\Ports\In\coin\SetFactory;

class OrderServiceService implements OrderService {

    private SetFactory $setFactory;

    public function __construct(SetFactory $setFactory) {
        $this->setFactory = $setFactory;
    }

    public function order(Set $set): Set {
        if ($this->isOrderedFromHighestToLowest($set)) {
            return $set;
        }
        $setArray = $set->getCoinsAsArray();
        usort($setArray, function (iCoin $a, iCoin $b): int {
            if ($a->getValue() > $b->getValue()) {
                return -1;
            } elseif ($a->getValue() < $b->getValue()) {
                return 1;
            }
            return 0;
        });
        return $this->setFactory->create(...$setArray);
    }

    private function isOrderedFromHighestToLowest(Set $set): bool {
        $coins = $set->getCoinsAsArray();
        if (sizeof($coins) === 0) {
            return true;
        }
        $initialValue = $coins[0]->getValue();
        foreach ($coins as $coin) {
            if ($coin->getValue() > $initialValue) {
                return false;
            }
        }
        return true;
    }
}
