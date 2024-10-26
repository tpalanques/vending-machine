<?php

namespace app;

use app\Ports\In\change\Factory as ChangeFactory;
use app\Ports\In\coin\Factory as CoinFactory;
use app\Ports\In\coin\SetFactory as CoinSetFactory;
use app\Ports\In\processor\Factory as ProcessorFactory;
use app\Ports\In\machine\BuyServiceFactory;
use app\Ports\In\product\Factory as ProductFactory;
use app\Ports\In\product\Product as iProduct;
use app\Ports\In\product\SetFactory as ProductSetFactory;
use app\Ports\In\stock\Factory as StockFactory;
use app\Ports\In\stock\Stock as iStock;
use app\Ports\Out\input\InputFactory;
use app\Ports\Out\view\Factory as ViewFactory;
use app\Ports\Out\view\interactive\Factory as InteractiveViewFactory;

class DependencyBuilder {

    public function getInteractiveViewFactory(): InteractiveViewFactory {
        $stockFactory = new StockFactory(new ProductSetFactory());
        $productFactory = new ProductFactory();
        return new InteractiveViewFactory(
            new ProcessorFactory(),
            new ViewFactory(),
            (new InputFactory())->getKeyboardString(),
            (new CoinSetFactory())->createEmpty(),
            $this->buildStock($stockFactory, $productFactory->getJuice(),Config::STOCK['juice']),
            $this->buildStock($stockFactory, $productFactory->getSoda(),Config::STOCK['soda']),
            $this->buildStock($stockFactory, $productFactory->getWater(),Config::STOCK['water']),
            new CoinFactory(),
            (new BuyServiceFactory((new ChangeFactory())->getKeepAll()))->get()
        );
    }

    private function buildStock(StockFactory $stockFactory, iProduct $product, int $amount): iStock {
        $stock = $stockFactory->create($product);
        $stock->add($amount);
        return $stock;
    }
}
