<?php

namespace app\Ports\Out\view\interactive;

use app\Domain\Entity\view\interactive\Main;
use app\Domain\Entity\view\interactive\Service;
use app\Ports\Out\view\Factory as ViewFactory;
use app\Ports\Out\view\interactive\Interactive as iInteractive;
use app\Ports\In\processor\Factory as ProcessorFactory;

class Factory {

    private ProcessorFactory $processorFactory;
    private ViewFactory $viewFactory;

    public function __construct(
        ProcessorFactory $processorFactory,
        ViewFactory      $viewFactory
    ) {
        $this->processorFactory = $processorFactory;
        $this->viewFactory = $viewFactory;
    }

    public function getMain(): iInteractive {
        return new Main($this, $this->viewFactory->getMain(), $this->processorFactory->getMain());
    }

    public function getService(): iInteractive {
        return new Service($this, $this->viewFactory->getService(), $this->processorFactory->getService());
    }

}
