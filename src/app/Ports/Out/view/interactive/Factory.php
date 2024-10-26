<?php

namespace app\Ports\Out\view\interactive;

use app\Domain\Entity\view\interactive\Main;
use app\Domain\Entity\view\interactive\Service;
use app\Ports\In\coin\Factory as CoinFactory;
use app\Ports\In\coin\Set as iCoinSet;
use app\Ports\In\machine\BuyService as iBuyService;
use app\Ports\In\stock\Stock as iStock;
use app\Ports\Out\input\Input as iInput;
use app\Ports\Out\view\Factory as ViewFactory;
use app\Ports\Out\view\interactive\Interactive as iInteractive;
use app\Ports\In\processor\Factory as ProcessorFactory;

class Factory {

    private ProcessorFactory $processorFactory;
    private ViewFactory $viewFactory;
    private iInput $input;
    private iCoinSet $credit;
    private iCoinSet $change;
    private iStock $juice;
    private iStock $soda;
    private iStock $water;
    private CoinFactory $coinFactory;
    private iBuyService $buyService;

    public function __construct(
        ProcessorFactory $processorFactory,
        ViewFactory      $viewFactory,
        iInput           $input,
        iCoinSet         $credit,
        iCoinSet         $change,
        iStock           $juice,
        iStock           $soda,
        iStock           $water,
        CoinFactory      $coinFactory,
        iBuyService      $buyService
    ) {
        $this->processorFactory = $processorFactory;
        $this->viewFactory = $viewFactory;
        $this->input = $input;
        $this->credit = $credit;
        $this->change = $change;
        $this->juice = $juice;
        $this->soda = $soda;
        $this->water = $water;
        $this->coinFactory = $coinFactory;
        $this->buyService = $buyService;
    }

    public function getMain(): iInteractive {
        return new Main(
            $this,
            $this->viewFactory->getMain(
                $this->credit,
                $this->juice,
                $this->soda,
                $this->water
            ),
            $this->processorFactory->getMain(
                $this->input,
                $this->credit,
                $this->change,
                $this->juice,
                $this->soda,
                $this->water,
                $this->coinFactory,
                $this->buyService
            )
        );
    }

    public function getService(): iInteractive {
        return new Service(
            $this,
            $this->viewFactory->getService($this->juice, $this->soda, $this->water),
            $this->processorFactory->getService($this->input, $this->juice, $this->soda, $this->water)
        );
    }

}
