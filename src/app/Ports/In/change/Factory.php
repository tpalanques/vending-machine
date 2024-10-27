<?php

namespace app\Ports\In\change;

use app\Application\change\KeepAll;
use app\Ports\In\change\Service as iService;
use app\Application\change\SaveCredit;

class Factory {

    public function getKeepAll(): iService {
        return new KeepAll();
    }

    public function getSaveCredit(): iService {
        return new SaveCredit();
    }
}
