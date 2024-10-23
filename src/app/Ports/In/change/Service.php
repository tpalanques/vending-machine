<?php

namespace app\Ports\In\change;

use app\Ports\In\coin\Set as iSet;

interface Service {
    public function get(iSet $coins, float $price): iSet;
}
