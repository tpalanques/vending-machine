<?php

namespace app\Ports\In\coin;

use app\Application\coin\OrderServiceService;
use app\Ports\In\coin\OrderService as iOrderService;

class OrderServiceFactory {

    private SetFactory $setFactory;

    public function __construct(SetFactory $setFactory) {
        $this->setFactory = $setFactory;
    }

    public function get(): iOrderService {
        return new OrderServiceService($this->setFactory);
    }

}
