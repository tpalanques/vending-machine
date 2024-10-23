<?php

namespace app\Domain\Entity\product;

use app\Domain\Entity\coin\Coin;
use app\Ports\In\product\Product as iProduct;

class Product implements iProduct {

    private string $name;
    private float $price;

    public function __construct(string $name, float $price) {
        $this->name = $name;
        $this->price = round($price, Coin::getPrecision());
    }

    public function getName(): string {
        return $this->name;
    }

    public function getPrice(): float {
        return round($this->price, Coin::getPrecision());
    }
}
