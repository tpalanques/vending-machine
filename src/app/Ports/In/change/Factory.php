<?php

namespace app\Ports\In\change;

use app\Ports\In\coin\OrderService as iOrderService;
use app\Application\change\KeepAll;
use app\Ports\In\change\Service as iService;
use app\Application\change\SaveCredit;

class Factory {

    private iOrderService $orderService;

    public function __construct(iOrderService $orderService) {
        $this->orderService = $orderService;
    }

    public function getKeepAll(): iService {
        return new KeepAll();
    }

    public function getSaveCredit(): iService {
        return new SaveCredit($this->orderService);
    }
}
