<?php

namespace app\Ports\Out\view\interactive;

use app\Ports\Out\view\Console as iConsole;
use app\Ports\In\processor\Processor as iProcessor;

interface Interactive {
    public function getView(): iConsole;

    public function getProcessor(): iProcessor;

}
