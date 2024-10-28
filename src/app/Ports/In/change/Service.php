<?php

namespace app\Ports\In\change;

use app\Ports\In\coin\Set as iSet;

interface Service {

    /**
     * @throws NotEnoughChange
     */
    public function get(iSet $credit, float $price, iSet $change): iSet;
}
