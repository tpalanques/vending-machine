<?php

namespace app\Domain\Entity\product\set;

use app\Ports\In\product\SetFactory;
use app\Ports\In\product\Set as iSet;
use app\Ports\In\product\Factory as ProductFactory;
use app\Ports\In\product\Product as iProduct;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class SetTest extends TestCase {

    private SetFactory $setFactory;
    private ProductFactory $productFactory;

    protected function setUp(): void {
        parent::setUp();
        $this->productFactory = new ProductFactory();
        $this->setFactory = new SetFactory();
    }

    public function testEmptySet() {
        $sut = $this->setFactory->createEmpty();
        $this->assertEmpty($sut->getProducts());
    }

    #[DataProvider('product')]
    public function testAddSingleProductToEmptySet(iProduct $product) {
        $sut = $this->setFactory->createEmpty();
        $sut->add($product);
        $this->assertCount(1, $sut->getProducts());
        $this->assertEquals($product, $sut->getProducts()[0]);
    }

    #[DataProvider('product')]
    public function testCreateSetWithSingleProduct(iProduct $product) {
        $sut = $this->setFactory->create($product);
        $this->assertCount(1, $sut->getProducts());
        $this->assertEquals($product, $sut->getProducts()[0]);
    }

    public static function product(): array {
        $productFactory = new ProductFactory();
        return [
            [$productFactory->getJuice()],
            [$productFactory->getSoda()],
            [$productFactory->getWater()],
        ];
    }

    #[DataProvider('setAndProduct')]
    public function testAddProductToFilledSet(iSet $sut, iProduct $product) {
        $count = count($sut->getProducts());
        $sut->add($product);
        $this->assertCount($count + 1, $sut->getProducts());
        $this->assertEquals($product, $sut->getProducts()[$count]);
    }

    public static function setAndProduct(): array {
        $productFactory = new ProductFactory();
        $setFactory = new SetFactory();
        $set = $setFactory->create(
            $productFactory->getJuice(),
            $productFactory->getSoda(),
            $productFactory->getWater(),
        );
        return [
            [$set, $productFactory->getJuice()],
            [$set, $productFactory->getSoda()],
            [$set, $productFactory->getWater()]
        ];
    }

    #[DataProvider('multipleProducts')]
    public function testCreateSetWithMultipleProducts(iProduct ...$products) {
        $sut = $this->setFactory->create(...$products);
        $this->assertCount(count($products), $sut->getProducts());
        $savedProducts = $sut->getProducts();
        foreach ($products as $index => $product) {
            $this->assertEquals($product, $savedProducts[$index]);
        }
    }

    public static function multipleProducts(): array {
        $productFactory = new ProductFactory();
        return [
            [$productFactory->getJuice(), $productFactory->getJuice(), $productFactory->getJuice()],
            [$productFactory->getJuice(), $productFactory->getJuice(), $productFactory->getSoda()],
            [$productFactory->getJuice(), $productFactory->getJuice(), $productFactory->getWater()],
            [$productFactory->getJuice(), $productFactory->getSoda(), $productFactory->getJuice()],
            [$productFactory->getJuice(), $productFactory->getSoda(), $productFactory->getSoda()],
            [$productFactory->getJuice(), $productFactory->getSoda(), $productFactory->getWater()],
            [$productFactory->getJuice(), $productFactory->getWater(), $productFactory->getJuice()],
            [$productFactory->getJuice(), $productFactory->getWater(), $productFactory->getSoda()],
            [$productFactory->getJuice(), $productFactory->getWater(), $productFactory->getWater()],
            [$productFactory->getSoda(), $productFactory->getJuice(), $productFactory->getJuice()],
            [$productFactory->getSoda(), $productFactory->getJuice(), $productFactory->getSoda()],
            [$productFactory->getSoda(), $productFactory->getJuice(), $productFactory->getWater()],
            [$productFactory->getSoda(), $productFactory->getSoda(), $productFactory->getJuice()],
            [$productFactory->getSoda(), $productFactory->getSoda(), $productFactory->getSoda()],
            [$productFactory->getSoda(), $productFactory->getSoda(), $productFactory->getWater()],
            [$productFactory->getSoda(), $productFactory->getWater(), $productFactory->getJuice()],
            [$productFactory->getSoda(), $productFactory->getWater(), $productFactory->getSoda()],
            [$productFactory->getSoda(), $productFactory->getWater(), $productFactory->getWater()],
            [$productFactory->getWater(), $productFactory->getJuice(), $productFactory->getJuice()],
            [$productFactory->getWater(), $productFactory->getJuice(), $productFactory->getSoda()],
            [$productFactory->getWater(), $productFactory->getJuice(), $productFactory->getWater()],
            [$productFactory->getWater(), $productFactory->getSoda(), $productFactory->getJuice()],
            [$productFactory->getWater(), $productFactory->getSoda(), $productFactory->getSoda()],
            [$productFactory->getWater(), $productFactory->getSoda(), $productFactory->getWater()],
            [$productFactory->getWater(), $productFactory->getWater(), $productFactory->getJuice()],
            [$productFactory->getWater(), $productFactory->getWater(), $productFactory->getSoda()],
            [$productFactory->getWater(), $productFactory->getWater(), $productFactory->getWater()],
        ];
    }

    #[DataProvider('product')]
    public function testRemoveFromEmptySet(iProduct $product) {
        $sut = $this->setFactory->createEmpty();
        $sut->remove($product);
        $this->assertCount(0, $sut->getProducts());
    }

    #[DataProvider('removeProductFromSet')]
    public function testRemoveProductFromFilledSet(iSet $sut, iProduct $product) {
        $count = count($sut->getProducts());
        $sut->remove($product);
        $this->assertCount($count - 1, $sut->getProducts());
        foreach ($sut->getProducts() as $currentProduct) {
            $this->assertNotEquals($currentProduct, $product);
        }
    }

    public static function removeProductFromSet(): array {
        $productFactory = new ProductFactory();
        $setFactory = new SetFactory();
        $set = $setFactory->create(
            $productFactory->getJuice(),
            $productFactory->getSoda(),
            $productFactory->getWater(),
        );
        return [
            [$set, $productFactory->getJuice()],
            [$set, $productFactory->getSoda()],
            [$set, $productFactory->getWater()]
        ];
    }
}
