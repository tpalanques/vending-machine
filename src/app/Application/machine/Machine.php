<?php

namespace app\Application\machine;

use app\Ports\Out\view\interactive\Factory as InteractiveViewFactory;

class Machine {

    private const int JUICE_STARTING_STOCK = 3;
    private const int SODA_STARTING_STOCK = 5;
    private const int WATER_STARTING_STOCK = 1;

    private InteractiveViewFactory $interactiveViewFactory;

    public function __construct(InteractiveViewFactory $interactiveViewFactory) {
        $this->interactiveViewFactory = $interactiveViewFactory;
        // TODO move refill stocks method as it doesn't have access to stocks
        //$this->refillStocks();
    }

    public function run(): void {
        $interactiveView = $this->interactiveViewFactory->getMain();
        while ($interactiveView) {
            echo $interactiveView->getView()->render();
            $interactiveView->getProcessor()->process();
            $interactiveView = $interactiveView->getNextInteractiveView();
        }
    }

    private function refillStocks(): void {
        $this->juice->add(self::JUICE_STARTING_STOCK);
        $this->soda->add(self::SODA_STARTING_STOCK);
        $this->water->add(self::WATER_STARTING_STOCK);
    }
}
