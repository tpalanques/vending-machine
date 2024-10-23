<?php

namespace app\Application\machine;

use app\UI\machine\View;
use app\Ports\In\coin\Factory as CoinFactory;
use app\Ports\In\coin\Set as CoinSet;
use app\Ports\In\coin\SetFactory as CoinSetFactory;

class Machine {

    private CoinFactory $coinFactory;
    private CoinSet $insertedCoinSet;

    public function __construct() {
        $this->coinFactory = new CoinFactory();
        $this->insertedCoinSet = (new CoinSetFactory())->createEmpty();
    }

    public function run(): void {
        while (true) {
            echo $this->getView($this->insertedCoinSet)->render();
            $this->processAnswer($this->getAnswer());
        }
    }

    public function getView(CoinSet $insertedCoinSet): View {
        return new View($insertedCoinSet);
    }

    private function getAnswer(): string {
        $handle = fopen("php://stdin", "r");
        $line = fgets($handle);
        fclose($handle);
        return $line;
    }

    private function processAnswer(string $answer): void {
        switch ($answer) {
            case "1":
                $this->insertedCoinSet->add($this->coinFactory->getFiveCent());
                return;
            case "2":
                $this->insertedCoinSet->add($this->coinFactory->getTenCent());
                return;
            case "3":
                $this->insertedCoinSet->add($this->coinFactory->getQuarter());
                return;
            case "4":
                $this->insertedCoinSet->add($this->coinFactory->getOne());
                return;
            case "0":
                exit;
            default:
                echo "Invalid option" . PHP_EOL;
                break;
        }
    }
}
