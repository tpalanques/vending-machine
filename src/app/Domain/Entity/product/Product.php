<?php

namespace app\Domain\Entity\product;

use app\Ports\In\product\Product as iProduct;
use app\Config;

class Product implements iProduct {

    private string $name;
    private float $price;

    public function __construct(string $name, float $price) {
        $this->name = $name;
        $this->price = round($price, $this->getPrecision());
    }

    public function getName(): string {
        return $this->name;
    }

    public function getPrice(): float {
        return round($this->price, $this->getPrecision());
    }

    private function getPrecision(): int {
        return Config::COIN_PRECISION;
    }
}
