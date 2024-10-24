<?php

namespace app\Ports\In\product;

use app\Ports\In\product\Product as iProduct;
use app\Domain\Entity\product\set\Set;
use app\Ports\In\product\Set as iSet;
use app\Domain\Entity\product\set\SingleTypedTyped;
use app\Ports\In\product\SingleTypedSet as iSingleSet;

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

    public function createSingleTyped(iProduct $product): iSingleSet {
        return new SingleTypedTyped($this->createEmpty(), $product);
    }
}
