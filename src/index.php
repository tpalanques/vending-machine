<?php declare(strict_types=1);
require __DIR__ . '/vendor/autoload.php';

class index {

    public function __construct() {
        $this->run();
    }

    public function run(): void {
        new \app\application\main();
    }
}

//$app = new index();
echo "<h1> Hello world!</h1>";
