<?php

namespace app\Application\input;

use app\Ports\Out\input\Input as iInput;

class KeyboardString implements iInput {

    public function get(): string {
        $handle = fopen("php://stdin", "r");
        $line = fgets($handle);
        fclose($handle);
        return $line;
    }
}
