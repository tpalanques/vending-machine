<?php

namespace app\Ports\In\stock;

use app\Ports\In\product\Product as iProduct;
use app\Ports\In\product\SetFactory;
use app\Application\stock\Stock;
use app\Application\stock\Stock as iStock;

class Factory {

    private SetFactory $setFactory;

    public function __construct(SetFactory $setFactory) {
        $this->setFactory = $setFactory;
    }

    public function create(iProduct $product): iStock {
        return new Stock($this->setFactory->createSingleTyped($product));
    }

}
