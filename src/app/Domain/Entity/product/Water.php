<?php

namespace app\Domain\Entity\product;

use app\Ports\In\product\Product as iProduct;

class Water implements iProduct {

    private const string NAME = "Water";
    private const float PRICE = 0.65;

    private Product $product;

    public function __construct() {
        $this->product = new Product(self::NAME, self::PRICE);
    }

    public function getName(): string {
        return $this->product->getName();
    }

    public function getPrice(): float {
        return $this->product->getPrice();
    }
}
