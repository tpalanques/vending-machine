<?php

namespace app\Application\change;

use app\Config;
use app\Ports\In\change\Service as iService;
use app\Ports\In\change\NotEnoughChange;
use app\Ports\In\coin\OrderService as iOrderService;
use app\Ports\In\coin\Set as iCoinSet;

class SaveCredit implements iService {

    private iOrderService $orderService;

    public function __construct(iOrderService $orderService) {
        $this->orderService = $orderService;
    }

    public function get(iCoinSet $credit, float $price, iCoinSet $change): iCoinSet {
        $insertedMoney = $credit->getValue();
        $this->moveCreditToChange($credit, $change);
        $change = $this->orderService->order($change);
        try {
            $coinsToReturn = $this->getCoinsToReturn($change->getAsArray(), $insertedMoney - $price);
        } catch (NotEnoughChange $exception) {
            $coinsToReturn = $this->getCoinsToReturn($change->getAsArray(), $insertedMoney);
            echo $exception->getMessage();
        }
        $this->removeCoinsFromSet($change, $coinsToReturn);
        return $this->addCoinsToSet($credit, $coinsToReturn);
    }

    private function moveCreditToChange(iCoinSet $credit, iCoinSet $change): void {
        foreach ($credit->empty() as $coin) {
            $change->add($coin);
        }
    }

    /**
     * @throws NotEnoughChange
     */
    private function getCoinsToReturn(array $coins, float $change): array {
        $currentCoin = array_pop($coins);
        if (round($change, Config::COIN_PRECISION) === 0.0 || is_null($currentCoin)) {
            return [];
        }
        if ($change < 0) {
            throw new NotEnoughChange();
        }
        try {
            $moreCoins = $this->getCoinsToReturn($coins, round($change - $currentCoin->getValue(), Config::COIN_PRECISION));
            return array_merge([$currentCoin], $moreCoins);
        } catch (NotEnoughChange $exception) {
            throw new NotEnoughChange();
        }
    }

    private function addCoinsToSet(iCoinSet $set, array $coins): iCoinSet {
        foreach ($coins as $coin) {
            $set->add($coin);
        }
        return $set;
    }

    private function removeCoinsFromSet(iCoinSet $set, array $coins): iCoinSet {
        foreach ($coins as $coin) {
            $set->remove($coin);
            echo "Here's your: " . $coin->getValue() . " coin" . PHP_EOL;
        }
        return $set;
    }
}
