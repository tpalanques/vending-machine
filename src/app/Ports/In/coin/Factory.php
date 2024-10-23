<?php

namespace app\Ports\In\coin;

use app\Domain\Entity\coin\Coin;
use app\Application\coin\ValueService;
use app\Ports\In\coin\Coin as iCoin;

class Factory {

    private ValueService $valueService;

    public function __construct() {
        $this->valueService = (new ValueServiceFactory())->get();
    }

    private function create(float $value): iCoin {
        return new Coin($this->valueService, $value);
    }

    public function getFiveCent(): iCoin {
        return $this->create($this->valueService->getFiveCent());
    }

    public function getTenCent(): iCoin {
        return $this->create($this->valueService->getTenCent());
    }

    public function getQuarter(): iCoin {
        return $this->create($this->valueService->getQuarter());
    }

    public function getOne(): iCoin {
        return $this->create($this->valueService->getOne());
    }
}
