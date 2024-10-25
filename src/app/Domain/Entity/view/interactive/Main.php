<?php

namespace app\Domain\Entity\view\interactive;

use app\Ports\In\processor\Processor as iProcessor;
use app\Ports\Out\view\Console as iConsole;
use app\Ports\Out\view\interactive\Interactive as iInteractiveView;

class Main implements iInteractiveView {

    private iConsole $view;
    private iProcessor $processor;

    public function __construct(iConsole $view, iProcessor $processor) {
        $this->view = $view;
        $this->processor = $processor;
    }

    public function getProcessor(): iProcessor {
        return $this->processor;
    }

    public function getView(): iConsole {
        return $this->view;
    }
}
