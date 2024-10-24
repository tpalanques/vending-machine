<?php

namespace app\Ports\In\stock;

use app\Ports\In\product\Product as iProduct;

interface Stock {

    public function get(): int;

    public function getProduct(): iProduct;

    public function add(int $amount): void;

    /**
     * @throws InsufficientStock
     */
    public function remove(int $amount): void;

    public function isAvailable(): bool;
}
