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
    private iInput $input;
    private CoinSet $credit;
    private CoinSet $change;
    private iStock $juice;
    private iStock $soda;
    private iStock $water;
    private CoinFactory $coinFactory;
    private iBuyService $buyService;

    public function __construct(
        iInput      $input,
        CoinSet     $credit,
        CoinSet     $change,
        iStock      $juice,
        iStock      $soda,
        iStock      $water,
        CoinFactory $coinFactory,
        iBuyService $buyService
    ) {
        $this->input = $input;
        $this->credit = $credit;
        $this->change = $change;
        $this->juice = $juice;
        $this->soda = $soda;
        $this->water = $water;
        $this->coinFactory = $coinFactory;
        $this->buyService = $buyService;
    }

    public function getMain(): iProcessor {
        return new Main($this->input, $this->credit, $this->change, $this->juice, $this->soda, $this->water, $this->coinFactory, $this->buyService);
    }

    public function getService(): iProcessor {
        return new Service($this->input, $this->juice, $this->soda, $this->water);
    }
}
