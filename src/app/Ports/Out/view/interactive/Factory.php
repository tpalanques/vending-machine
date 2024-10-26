<?php

namespace app\Ports\Out\view\interactive;

use app\Domain\Entity\view\interactive\Main;
use app\Domain\Entity\view\interactive\Service;
use app\Ports\In\coin\Factory as CoinFactory;
use app\Ports\In\coin\Set as CoinSet;
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

    public function __construct(ProcessorFactory $processorFactory, ViewFactory $viewFactory, iInput $input) {
        $this->processorFactory = $processorFactory;
        $this->viewFactory = $viewFactory;
        $this->input = $input;
    }

    public function getMain(
        CoinSet     $insertedCoinSet,
        iStock      $juice,
        iStock      $soda,
        iStock      $water,
        CoinFactory $coinFactory,
        iBuyService $buyService
    ): iInteractive {
        return new Main(
            $this,
            $this->viewFactory->getMain($insertedCoinSet, $juice, $soda, $water),
            $this->processorFactory->getMain($this->input, $insertedCoinSet, $juice, $soda, $water, $coinFactory, $buyService)
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
