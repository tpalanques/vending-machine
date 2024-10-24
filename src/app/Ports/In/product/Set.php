<?php

namespace app\Ports\In\product;

use app\Ports\In\product\Product as iProduct;

interface Set {
    public function add(iProduct $product): void;

    public function remove(iProduct $product): void;

    /**
     * @return iProduct[]
     */
    public function getProducts(): array;
}
