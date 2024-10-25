<?php declare(strict_types=1);

use app\DependencyBuilder;
use app\Application\machine\Machine;

require __DIR__ . '/vendor/autoload.php';

class index {

    public function __construct() {
        $this->run();
    }

    public function run(): void {
        $dependencyBuilder = new DependencyBuilder();
        $machine = new Machine(
            $dependencyBuilder->getBuyService(),
            $dependencyBuilder->getCoinFactory(),
            $dependencyBuilder->getInput(),
            $dependencyBuilder->getProductFactory(),
            $dependencyBuilder->getInsertedCoinSet(),
            $dependencyBuilder->getStockFactory(),
            $dependencyBuilder->getViewFactory()
        );
        $machine->run();
    }
}

$app = new index();
