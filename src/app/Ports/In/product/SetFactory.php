<?php

namespace app\Ports\In\product;

use app\Ports\In\product\Product as iProduct;
use app\Domain\Entity\coin\Set;
use app\Ports\In\product\Set as iSet;

class SetFactory {

    public function createEmpty(): iSet {
        return new Set();
    }

    public function create(iProduct ...$products): iSet {
        $set = new Set();
        foreach ($products as $product) {
            $set->add($product);
        }
        return $set;
    }
}
