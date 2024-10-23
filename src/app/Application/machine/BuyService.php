<?php

namespace app\Application\machine;

use app\Ports\In\coin\Set as iCoinSet;
use app\Ports\In\change\Service as iChangeService;
use app\Ports\In\machine\BuyService as iBuyService;
use app\Ports\In\machine\NotEnoughCash;
use app\Ports\In\product\Product as iProduct;

class BuyService implements iBuyService {

    private iChangeService $changeService;

    public function __construct(iChangeService $changeService) {
        $this->changeService = $changeService;
    }

    public function buy(iProduct $product, iCoinSet $coins): iCoinSet {
        if ($product->getPrice() > $coins->getValue()) {
            throw new NotEnoughCash($product, $coins);
        }
        return $this->changeService->get($coins, $product->getPrice());
    }
}
