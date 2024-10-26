<?php

namespace app\Ports\In\processor;

use app\Application\input\processor\Service;
use app\Ports\In\coin\Factory as CoinFactory;
use app\Ports\In\coin\Set as CoinSet;
use app\Ports\In\processor\Processor as iProcessor;
use app\Application\input\processor\Main;
use app\Ports\In\machine\BuyService as iBuyService;
use app\Ports\In\stock\Stock as iStock;
use app\Ports\Out\input\Input as iInput;

class Factory {

    public function getMain(
        iInput      $input,
        CoinSet     $insertedCoinSet,
        iStock      $juice,
        iStock      $soda,
        iStock      $water,
        CoinFactory $coinFactory,
        iBuyService $buyService
    ): iProcessor {
        return new Main($input, $insertedCoinSet, $juice, $soda, $water, $coinFactory, $buyService);
    }

    public function getService(iInput $input, $juice, $soda, $water): iProcessor {
        return new Service($input, $juice, $soda, $water,);
    }
}
