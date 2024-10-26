<?php

namespace app\Ports\Out\view\interactive;

use app\Domain\Entity\view\interactive\Main as MainInteractiveView;
use app\Domain\Entity\view\interactive\Sercice as ServiceInteractiveView;
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

    public function __construct(ProcessorFactory $processorFactory, ViewFactory $viewFactory) {
        $this->processorFactory = $processorFactory;
        $this->viewFactory = $viewFactory;
    }

    public function getMain(
        iInput      $input,
        CoinSet     $insertedCoinSet,
        iStock      $juice,
        iStock      $soda,
        iStock      $water,
        CoinFactory $coinFactory,
        iBuyService $buyService
    ): iInteractive {
        return new MainInteractiveView(
            $this,
            $this->viewFactory->getMain($insertedCoinSet, $juice, $soda, $water),
            $this->processorFactory->getMain($input, $insertedCoinSet, $juice, $soda, $water, $coinFactory, $buyService)
        );
    }

    public function getService(iInput $input): iInteractive {
        return new Service(
            $this,
            $this->viewFactory->getService(),
            $this->processorFactory->getService($input)
        );
    }

}
