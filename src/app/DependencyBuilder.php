<?php

namespace app;

use app\Ports\In\change\Factory as ChangeFactory;
use app\Ports\In\coin\Factory as CoinFactory;
use app\Ports\In\coin\OrderServiceFactory;
use app\Ports\In\coin\SetFactory as CoinSetFactory;
use app\Ports\In\machine\BuyService as iBuyService;
use app\Ports\In\processor\Factory as ProcessorFactory;
use app\Ports\In\machine\BuyServiceFactory;
use app\Ports\In\product\Factory as ProductFactory;
use app\Ports\In\product\Product as iProduct;
use app\Ports\In\product\SetFactory as ProductSetFactory;
use app\Ports\In\stock\Factory as StockFactory;
use app\Ports\In\stock\Stock as iStock;
use app\Ports\Out\input\InputFactory;
use app\Ports\Out\input\Input as iInput;
use app\Ports\Out\view\Factory as ViewFactory;
use app\Ports\Out\view\interactive\Factory as InteractiveViewFactory;

class DependencyBuilder {

    public function getInteractiveViewFactory(): InteractiveViewFactory {
        $input = $this->getInput();
        $coinFactory = new CoinFactory();
        $coinSetFactory = new CoinSetFactory();
        $credit = $coinSetFactory->create();
        $change = $coinSetFactory->create();
        $productFactory = new ProductFactory();
        $stockFactory = new StockFactory(new ProductSetFactory());
        $juiceStock = $this->buildStock($stockFactory, $productFactory->getJuice(), Config::STOCK['juice']);
        $sodaStock = $this->buildStock($stockFactory, $productFactory->getSoda(), Config::STOCK['soda']);
        $waterStock = $this->buildStock($stockFactory, $productFactory->getWater(), Config::STOCK['water']);
        $buyService = $this->getBuyService($coinSetFactory);
        return new InteractiveViewFactory(
            new ProcessorFactory($input, $credit, $change, $juiceStock, $sodaStock, $waterStock, $coinFactory, $buyService),
            new ViewFactory($credit, $change, $juiceStock, $sodaStock, $waterStock)
        );
    }

    private function getBuyService(CoinSetFactory $coinSetFactory): iBuyService {
        $orderService = (new OrderServiceFactory($coinSetFactory))->get();
        $changeService = (new ChangeFactory($orderService))->getKeepAll();
        $buyServiceFactory = new BuyServiceFactory($changeService);
        return $buyServiceFactory->get();
    }

    private function getInput(): iInput {
        return (new InputFactory())->getKeyboardString();
    }

    private function buildStock(StockFactory $stockFactory, iProduct $product, int $amount): iStock {
        $stock = $stockFactory->create($product);
        $stock->add($amount);
        return $stock;
    }
}
