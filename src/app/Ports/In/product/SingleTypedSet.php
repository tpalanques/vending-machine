<?php

namespace app\Ports\In\product;

use app\Ports\In\product\Set as iSet;
use app\Ports\In\product\Product as iProduct;

interface SingleTypedSet {

    public function __construct(iSet $set, iProduct $product);

    public function add(): void;

    public function remove(): void;

    public function count(): int;
}
