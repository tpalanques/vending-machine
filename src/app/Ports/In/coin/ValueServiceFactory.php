<?php

namespace app\Ports\In\coin;

use \app\Application\coin\ValueService;

class ValueServiceFactory {

    public function get(): ValueService {
        return new ValueService();
    }
}
