<?php

namespace app\Domain\Entity\product;

use app\Ports\In\product\Product as iProduct;
use app\Ports\In\product\Factory;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase {

    private Factory $sut;

    protected function setUp(): void {
        parent::setUp();
    }

    #[DataProvider('products')]
    public function testGetProduct(iProduct $product, string $name, float $price): void {
        $this->assertEquals($name, $product->getName());
        $this->assertEquals($price, $product->getPrice());
    }

    public static function products(): array {
        $sut = new Factory();
        return [
            [$sut->getJuice(), 'Juice', 1.0],
            [$sut->getSoda(), 'Soda', 1.5],
            [$sut->getWater(), 'Water', 0.65],
        ];
    }
}
