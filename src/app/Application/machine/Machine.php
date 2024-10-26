<?php

namespace app\Application\machine;

use app\Ports\Out\view\interactive\Factory as InteractiveViewFactory;

class Machine {

    private InteractiveViewFactory $interactiveViewFactory;

    public function __construct(InteractiveViewFactory $interactiveViewFactory) {
        $this->interactiveViewFactory = $interactiveViewFactory;
    }

    public function run(): void {
        $interactiveView = $this->interactiveViewFactory->getMain();
        while ($interactiveView) {
            echo $interactiveView->getView()->render();
            $interactiveView->getProcessor()->process();
            $interactiveView = $interactiveView->getNextInteractiveView();
        }
    }
}
