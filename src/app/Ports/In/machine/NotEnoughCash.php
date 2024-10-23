<?php

namespace app\Ports\In\machine;

use app\Ports\In\coin\Set as iCoinSet;
use app\Ports\In\product\Product as iProduct;
use Exception;

class NotEnoughCash extends Exception {
    public function __construct(iProduct $product, iCoinSet $coins) {
        parent::__construct(
            $coins->getValue() . " coins can't buy " . $product->getName() . " with price " . $product->getPrice()
        );
    }
}
