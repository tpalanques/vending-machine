<?php

namespace app\Application\input\processor;

use app\Ports\In\coin\Set as iCoinSet;
use app\Ports\In\processor\Processor as iProcessor;
use app\Ports\Out\input\Input as iInput;

class Service implements iProcessor {

    private const int AMOUNT = 1;

    private iInput $input;
    private iCoinSet $credit;

    public function __construct(iInput $input) {
        $this->input = $input;
    }

    public function process(): void {
        $this->input->wait();
        switch ($this->input->get()) {
            case "0":
                return;
            default:
                echo "Invalid option" . PHP_EOL;
        }
    }

    public function getOption(): string {
        return $this->input->get();
    }
}
