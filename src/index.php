<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

class index {

    public function __construct() {
        $this->run();
    }

    public function run(): void {
        $machine = new \app\Application\machine\Machine();
        $machine->run();
    }
}

$app = new index();
