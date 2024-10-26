<?php

namespace app\Application\input\processor;

use app\Ports\In\processor\Processor as iProcessor;
use app\Ports\In\stock\Stock as iStock;
use app\Ports\Out\input\Input as iInput;

class Service implements iProcessor {

    private const int AMOUNT = 1;

    private iInput $input;

    private iStock $juice;
    private iStock $soda;
    private iStock $water;

    public function __construct(iInput $input, iStock $juice, iStock $soda, iStock $water) {
        $this->input = $input;
        $this->juice = $juice;
        $this->soda = $soda;
        $this->water = $water;
    }

    public function process(): void {
        $this->input->wait();
        switch ($this->input->get()) {
            case "1":
                $this->juice->add(self::AMOUNT);
                return;
            case "2":
                $this->soda->add(self::AMOUNT);
                return;
            case "3":
                $this->water->add(self::AMOUNT);
                return;
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
