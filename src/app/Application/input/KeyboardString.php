<?php

namespace app\Application\input;

use app\Ports\Out\input\Input as iInput;

class KeyboardString implements iInput {

    private ?string $input;

    public function __construct() {
        $this->input = null;
    }

    public function wait(): void {
        $handle = fopen("php://stdin", "r");
        $this->input = fgets($handle);
        fclose($handle);
    }

    public function get(): string {
        return $this->input;
    }
}
