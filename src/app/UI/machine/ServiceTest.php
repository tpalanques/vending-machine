<?php

namespace app\UI\machine;

use app\Config;
use app\Ports\In\coin\Set as iCoinSet;
use app\Ports\In\product\Product as iProduct;
use app\Ports\In\stock\Stock as iStock;
use app\Ports\Out\view\Factory as ViewFactory;
use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase {

    private const float CREDIT = 0;
    private const float CHANGE = 2.4;
    private const array FIRST_PRODUCT = [
        'name' => 'First item',
        'price' => 6.5,
        'stock' => 3,
    ];
    private const array SECOND_PRODUCT = [
        'name' => 'Second item',
        'price' => 0.7,
        'stock' => 0,
    ];
    private const array THIRD_PRODUCT = [
        'name' => 'Third item',
        'price' => 1.1,
        'stock' => 7,
    ];
    private ViewFactory $viewFactory;

    protected function setUp(): void {
        parent::setUp();
        $this->viewFactory = new ViewFactory(
            $this->getCoinSetMock(self::CREDIT),
            $this->getCoinSetMock(self::CHANGE),
            $this->buildProductStock(self::FIRST_PRODUCT),
            $this->buildProductStock(self::SECOND_PRODUCT),
            $this->buildProductStock(self::THIRD_PRODUCT)
        );
    }

    public function testRender() {
        $sut = $this->viewFactory->getService();
        $this->assertEquals("WELCOME TO SERVICE MODE!								[Change: 2.4 coins]
Please select an option:
	 1) Insert 0.05 coin
	 2) Insert 0.10 coin
	 3) Insert 0.25 coin
	 4) Insert 1 coin
	 5) Add juice stock (3)
	 6) Add juice soda (0)
	 7) Add juice water (7)
	 0) Close service mode
", $sut->render());
    }

    private function buildProductStock(array $product): iStock {
        return $this->getStockMock(
            $this->getProductMock($product['name'], $product['price']),
            $product['stock']
        );
    }

    private function getCoinSetMock(float $value): iCoinSet {
        $mock = $this->createMock(iCoinSet::class);
        $mock->method('getValue')->willReturn(round($value, Config::COIN_PRECISION));
        return $mock;
    }

    private function getStockMock(iProduct $product, int $stock): iStock {
        $mock = $this->createMock(iStock::class);
        $mock->method('getProduct')->willReturn($product);
        $mock->method('get')->willReturn($stock);
        return $mock;
    }

    private function getProductMock(string $name, float $price): iProduct {
        $mock = $this->createMock(iProduct::class);
        $mock->method('getName')->willReturn($name);
        $mock->method('getPrice')->willReturn($price);
        return $mock;
    }
}
