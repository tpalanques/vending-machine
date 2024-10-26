<?php

namespace app\Application\machine;

use app\Ports\In\coin\Factory as CoinFactory;
use app\Ports\In\processor\Factory as InputProcessorFactory;
use app\Ports\In\machine\BuyService as iBuyService;
use app\Ports\In\product\Factory as ProductFactory;
use app\Ports\In\stock\Factory as StockFactory;
use app\Ports\In\stock\Stock as iStock;
use app\Ports\Out\view\interactive\Factory as InteractiveViewFactory;

class Machine {

    private const int JUICE_STARTING_STOCK = 3;
    private const int SODA_STARTING_STOCK = 5;
    private const int WATER_STARTING_STOCK = 1;

    private iBuyService $buyService;
    private CoinFactory $coinFactory;
    private iStock $juice;
    private iStock $soda;
    private iStock $water;
    private ProductFactory $productFactory;
    private InputProcessorFactory $inputProcessorFactory;
    private InteractiveViewFactory $interactiveViewFactory;

    public function __construct(
        iBuyService            $buyService,
        CoinFactory            $coinFactory,
        ProductFactory         $productFactory,
        StockFactory           $stockFactory,
        InteractiveViewFactory $interactiveViewFactory
    ) {
        $this->buyService = $buyService;
        $this->coinFactory = $coinFactory;
        $this->productFactory = $productFactory;
        $this->interactiveViewFactory = $interactiveViewFactory;
        $this->buildProductStocks($stockFactory, $this->productFactory);
        $this->refillStocks();
    }

    public function run(): void {
        $interactiveView = $this->interactiveViewFactory->getMain(
            $this->juice,
            $this->soda,
            $this->water,
            $this->coinFactory,
            $this->buyService
        );
        while ($interactiveView) {
            echo $interactiveView->getView()->render();
            $interactiveView->getProcessor()->process();
            $interactiveView = $interactiveView->getNextInteractiveView();
        }
    }

    private function buildProductStocks(StockFactory $stockFactory, ProductFactory $productFactory): void {
        $this->juice = $stockFactory->create($productFactory->getJuice());
        $this->soda = $stockFactory->create($productFactory->getSoda());
        $this->water = $stockFactory->create($productFactory->getWater());
    }

    private function refillStocks(): void {
        $this->juice->add(self::JUICE_STARTING_STOCK);
        $this->soda->add(self::SODA_STARTING_STOCK);
        $this->water->add(self::WATER_STARTING_STOCK);
    }
}
