<?php

namespace app\Application\change;

use app\Ports\In\change\Service as iService;
use app\Ports\In\change\NotEnoughCash;
use app\Ports\In\coin\OrderService as iOrderService;
use app\Ports\In\coin\Set as iCoinSet;

class SaveCredit implements iService {

    private iOrderService $orderService;

    public function __construct(iOrderService $orderService) {
        $this->orderService = $orderService;
    }

    public function get(iCoinSet $coins, float $price): iCoinSet {
        if ($price > $coins->getValue()) {
            throw new NotEnoughCash($coins, $price);
        }
        if ($coins->getValue() === $price) {
            $coins->empty();
            return $coins;
        } else {
            $coins = $this->orderService->order($coins);
            $coinsToSpend = $this->getCoinsToSpend($coins->getAsArray(), $price);
            $allCoins = $coins->empty();
            $change = array_udiff($allCoins, $coinsToSpend, function ($a, $b) {
                // FIXME: duplicated code
                if ($a->getValue() > $b->getValue()) {
                    return -1;
                } elseif ($a->getValue() < $b->getValue()) {
                    return 1;
                }
                return 0;
            });
            foreach ($change as $coin) {
                $coins->add($coin);
            }
        }
        return $coins;
    }

    private function getCoinsToSpend(array $coins, float $price): array {
        $currentCoin = array_shift($coins);;
        if ($currentCoin->getValue() >= $price) {
            return [$currentCoin];
        } else {
            $moreCoins = $this->getCoinsToSpend($coins, $price - $currentCoin->getValue());
            return array_merge([$currentCoin], $moreCoins);
        }
    }
}
