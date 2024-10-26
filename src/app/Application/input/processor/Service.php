<?php

namespace app\Application\input\processor;

use app\Ports\In\coin\Factory as CoinFactory;
use app\Ports\In\coin\Set as iCoinSet;
use app\Ports\In\processor\Processor as iProcessor;
use app\Ports\In\stock\Stock as iStock;
use app\Ports\Out\input\Input as iInput;

class Service implements iProcessor {

    private const int AMOUNT = 1;

    private iInput $input;
    private iCoinSet $change;
    private iStock $juice;
    private iStock $soda;
    private iStock $water;
    private CoinFactory $coinFactory;

    public function __construct(iInput $input, iCoinSet $change, iStock $juice, iStock $soda, iStock $water, $coinFactory) {
        $this->input = $input;
        $this->change = $change;
        $this->juice = $juice;
        $this->soda = $soda;
        $this->water = $water;
        $this->coinFactory = $coinFactory;
    }

    public function process(): void {
        $this->input->wait();
        switch ($this->input->get()) {
            case "1":
                $this->change->add($this->coinFactory->getFiveCent());
                return;
            case "2":
                $this->change->add($this->coinFactory->getTenCent());
                return;
            case "3":
                $this->change->add($this->coinFactory->getQuarter());
                return;
            case "4":
                $this->change->add($this->coinFactory->getOne());
                return;
            case "5":
                $this->juice->add(self::AMOUNT);
                return;
            case "6":
                $this->soda->add(self::AMOUNT);
                return;
            case "7":
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
