<?php

namespace app\Ports\In\product;

use app\Domain\Entity\product\Soda;
use app\Domain\Entity\product\Water;
use app\Ports\In\product\Product as iProduct;
use app\Domain\Entity\product\Juice;

class Factory {

    public function getJuice(): iProduct {
        return new Juice();
    }

    public function getSoda(): iProduct {
        return new Soda();
    }

    public function getWater(): iProduct {
        return new Water();
    }

}
