<?php

namespace app;

use app\Ports\In\change\Factory as ChangeFactory;
use app\Ports\In\coin\Factory as CoinFactory;
use app\Ports\In\coin\Set as CoinSet;
use app\Ports\In\coin\SetFactory as CoinSetFactory;
use app\Ports\In\processor\Factory as ProcessorFactory;
use app\Ports\In\machine\BuyService as iBuyService;
use app\Ports\In\machine\BuyServiceFactory;
use app\Ports\In\product\Factory as ProductFactory;
use app\Ports\In\product\SetFactory as ProductSetFactory;
use app\Ports\In\stock\Factory as StockFactory;
use app\Ports\Out\input\InputFactory;
use app\Ports\Out\view\Factory as ViewFactory;
use app\Ports\Out\view\interactive\Factory as InteractiveViewFactory;

class DependencyBuilder {

    public function getBuyService(): iBuyService {
        $changeStrategyFactory = new ChangeFactory();
        $changeStrategy = $changeStrategyFactory->getKeepAll();
        $buyServiceFactory = new BuyServiceFactory($changeStrategy);
        return $buyServiceFactory->get();
    }

    public function getCoinFactory(): CoinFactory {
        return new CoinFactory();
    }

    public function getInteractiveViewFactory(): InteractiveViewFactory {
        return new InteractiveViewFactory(
            new ProcessorFactory(),
            new ViewFactory(),
            (new InputFactory())->getKeyboardString(),
            (new CoinSetFactory())->createEmpty()
        );
    }

    public function getProductFactory(): ProductFactory {
        return new ProductFactory();
    }

    public function getStockFactory(): StockFactory {
        return new StockFactory(new ProductSetFactory());
    }
}
