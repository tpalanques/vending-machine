<?php

namespace app\Ports\In\coin;

use app\Ports\In\coin\Set as iSet;

interface OrderService {
    public function order(iSet $set): iSet;
}
