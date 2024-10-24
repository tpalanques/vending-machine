<?php

namespace app\Ports\In\stock;

interface Stock {

    public function get(): int;

    public function add(int $amount): void;

    /**
     * @throws InsufficientStock
     */
    public function remove(int $amount): void;

    public function isAvailable(): bool;
}
