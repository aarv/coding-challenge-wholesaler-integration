<?php

declare(strict_types=1);

namespace Kollex\Test\Unit;

use Kollex\Assortment\Model\BaseProductPackaging;
use Kollex\Assortment\Model\BaseProductUnit;
use Kollex\Assortment\Model\Packaging;
use Kollex\Assortment\Model\Product;
use Kollex\DataProvider\CsvDataProvider;
use PHPUnit\Framework\TestCase;

class CsvDataProviderTest extends TestCase
{
    public function testCanCreateValidProducts(): void
    {
        $provider = new CsvDataProvider(__DIR__ . '/../Data/all_valid.csv');
        $products = $provider->getProducts();

        self::assertCount(3, $products);

        /** @var Product $product */
        $product = $products[0];

        self::assertInstanceOf(Product::class, $product);
        self::assertEquals(12345600001, $product->getId());
        self::assertEquals(23880602029774, $product->getGtin());
        self::assertEquals('Drinks Corp.', $product->getManufacturer());
        self::assertEquals('Soda Drink, 12 * 1,0l', $product->getName());
        self::assertEquals(Packaging::TYPE_CASE, $product->getPackaging());
        self::assertEquals(BaseProductPackaging::TYPE_BOTTLE, $product->getBaseProductPackaging());
        self::assertEquals(BaseProductUnit::UNIT_LITER, $product->getBaseProductUnit());
        self::assertEquals(1, $product->getBaseProductAmount());
        self::assertEquals(123, $product->getBaseProductQuantity());
    }

    public function testCanCreateValidProductsWithGaps(): void
    {
        $provider = new CsvDataProvider(__DIR__ . '/../Data/not_all_valid.csv');
        $products = $provider->getProducts();

        self::assertCount(3, $products);
    }

    public function testCanNotCreateProductWithInvalidPackaging(): void
    {
        $provider = new CsvDataProvider(__DIR__ . '/../Data/invalid_packaging.csv');
        $products = $provider->getProducts();

        self::assertCount(0, $products);
    }

    public function testCanNotCreateProductWithInvalidBaseProductPackaging(): void
    {
        $provider = new CsvDataProvider(__DIR__ . '/../Data/invalid_base_product_packaging.csv');
        $products = $provider->getProducts();

        self::assertCount(0, $products);
    }

    public function testCanNotCreateProductWithInvalidBaseProductUnit(): void
    {
        $provider = new CsvDataProvider(__DIR__ . '/../Data/invalid_base_product_unit.csv');
        $products = $provider->getProducts();

        self::assertCount(0, $products);
    }
}