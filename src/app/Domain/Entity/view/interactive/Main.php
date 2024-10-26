<?php

namespace app\Domain\Entity\view\interactive;

use app\Application\input\KeyboardString;
use app\Ports\In\processor\Processor as iProcessor;
use app\Ports\Out\view\Console as iConsole;
use app\Ports\Out\view\interactive\Factory as InteractiveViewFactory;
use app\Ports\Out\view\interactive\Interactive as iInteractiveView;

class Main implements iInteractiveView {

    private InteractiveViewFactory $interactiveViewFactory;
    private iConsole $view;
    private iProcessor $processor;

    public function __construct(InteractiveViewFactory $interactiveViewFactory, iConsole $view, iProcessor $processor) {
        $this->interactiveViewFactory = $interactiveViewFactory;
        $this->view = $view;
        $this->processor = $processor;
    }

    public function getProcessor(): iProcessor {
        return $this->processor;
    }

    public function getView(): iConsole {
        return $this->view;
    }

    public function getNextInteractiveView(): ?iInteractiveView {
        switch ($this->getProcessor()->getOption()) {
            default:
                return $this;
            case 8:
                return $this->interactiveViewFactory->getService();
            case 0:
                return null;
        }
    }
}
