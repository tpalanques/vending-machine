<?php

namespace app\Ports\In\processor;

use app\Ports\Out\input\Input as iInput;

interface Processor {
    public function process(): void;
}
