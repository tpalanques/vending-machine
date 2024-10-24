<?php

namespace app\Domain\Entity\product\set;

use app\Ports\In\product\Product as iProduct;
use app\Ports\In\product\Set as iSet;
use app\Ports\In\product\SingleTypedSet as iSingleSet;

class SingleTypedTyped implements iSingleSet {

    private iSet $set;
    private iProduct $product;

    public function __construct(iSet $set, iProduct $product) {
        $this->set = $set;
        $this->product = $product;
    }

    public function getProduct(): iProduct {
        return $this->product;
    }

    public function add(): void {
        $this->set->add($this->product);
    }

    public function remove(): void {
        $this->set->remove($this->product);
    }

    public function count(): int {
        return count($this->set->getProducts());
    }
}
