<?php

namespace app\Ports\In\change;

use app\Application\change\KeepAll;
use app\Application\change\KeepAll as iService;

class Factory {

    public static function getKeepAll(): iService {
        return new KeepAll();
    }
}
