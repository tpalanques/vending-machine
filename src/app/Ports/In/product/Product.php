<?php

namespace app\Ports\In\product;

interface Product {

    public function getName(): string;

    public function getPrice(): float;
}
