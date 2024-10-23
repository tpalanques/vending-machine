<?php

namespace app\Ports\In\machine;

use app\Ports\In\change\Service as ChangeService;
use app\Ports\In\machine\BuyService as iBuyService;
use app\Application\machine\BuyService;

class BuyServiceFactory {

    private ChangeService $changeService;

    public function __construct(ChangeService $changeService) {
        $this->changeService = $changeService;
    }

    public function get(): iBuyService {
        return new BuyService($this->changeService);
    }

}
