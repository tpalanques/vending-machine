<?php

namespace app\Application\stock;

use app\Ports\In\product\SingleTypedSet as iSingleTypedSet;
use app\Ports\In\stock\InsufficientStock;
use app\Ports\In\stock\Stock as iStock;

class Stock implements iStock {

    private iSingleTypedSet $set;

    public function __construct(iSingleTypedSet $set) {
        $this->set = $set;
    }

    public function get(): int {
        return $this->set->count();
    }

    public function add(int $amount): void {
        for ($i = 0; $i < $amount; $i++) {
            $this->set->add();
        }
    }

    public function remove(int $amount): void {
        if ($amount >= $this->set->count()) {
            throw new InsufficientStock($amount, $this->set->count());
        }
        for ($i = 0; $i < $amount; $i++) {
            $this->set->remove();
        }
    }

    public function isAvailable(): bool {
        return $this->set->count() > 0;
    }
}
