<?php

namespace app\Domain\Entity\product;

use app\Ports\In\product\Product as iProduct;
use app\Ports\In\product\Set as iSet;

class Set implements iSet {
    private array $product = [];

    public function add(iProduct $product): void {
        $this->product[] = $product;
    }

    public function remove(iProduct $product): void {
        $index = null;
        foreach ($this->product as $productIndex => $currentProduct) {
            if ($currentProduct->getName() === $product->getName()) {
                $index = $productIndex;
            }
        }
        array_splice($this->product, $index, 1);
    }
}
