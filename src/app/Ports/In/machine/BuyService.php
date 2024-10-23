<?php

namespace app\Ports\In\machine;

use app\Ports\In\product\Product as iProduct;
use app\Ports\In\coin\Set as iCoinSet;

interface BuyService {
    public function buy(iProduct $product, iCoinSet $coins): iCoinSet;
}
