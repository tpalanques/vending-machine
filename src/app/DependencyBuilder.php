<?php

namespace app;

use app\Ports\In\change\Factory as ChangeFactory;
use app\Ports\In\coin\Factory as CoinFactory;
use app\Ports\In\coin\SetFactory as CoinSetFactory;
use app\Ports\In\processor\Factory as ProcessorFactory;
use app\Ports\In\machine\BuyServiceFactory;
use app\Ports\In\product\Factory as ProductFactory;
use app\Ports\In\product\SetFactory as ProductSetFactory;
use app\Ports\In\stock\Factory as StockFactory;
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
            $stockFactory->create($productFactory->getJuice()),
            $stockFactory->create($productFactory->getSoda()),
            $stockFactory->create($productFactory->getWater()),
            new CoinFactory(),
            (new BuyServiceFactory((new ChangeFactory())->getKeepAll()))->get()
        );
    }
}
