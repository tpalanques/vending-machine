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
        $coins = $this->orderService->order($coins);
        //$coins->empty();
        return $coins;
    }


}
