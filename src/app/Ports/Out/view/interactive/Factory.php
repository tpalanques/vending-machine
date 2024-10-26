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
    private iCoinSet $insertedCoinSet;
    private iStock $juice;
    private iStock $soda;
    private iStock $water;
    private CoinFactory $coinFactory;

    public function __construct(
        ProcessorFactory $processorFactory,
        ViewFactory      $viewFactory,
        iInput           $input,
        iCoinSet         $insertedCoinSet,
        iStock           $juice,
        iStock           $soda,
        iStock           $water,
        CoinFactory      $coinFactory
    ) {
        $this->processorFactory = $processorFactory;
        $this->viewFactory = $viewFactory;
        $this->input = $input;
        $this->insertedCoinSet = $insertedCoinSet;
        $this->juice = $juice;
        $this->soda = $soda;
        $this->water = $water;
        $this->coinFactory = $coinFactory;
    }

    public function getMain(
        iBuyService $buyService
    ): iInteractive {
        return new Main(
            $this,
            $this->viewFactory->getMain(
                $this->insertedCoinSet,
                $this->juice,
                $this->soda,
                $this->water
            ),
            $this->processorFactory->getMain(
                $this->input,
                $this->insertedCoinSet,
                $this->juice,
                $this->soda,
                $this->water,
                $this->coinFactory,
                $buyService
            )
        );
    }

    public function getService(): iInteractive {
        return new Service(
            $this,
            $this->viewFactory->getService(),
            $this->processorFactory->getService($this->input)
        );
    }

}
