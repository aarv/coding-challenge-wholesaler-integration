<?php

declare(strict_types=1);

namespace Kollex\Test\Unit;

use Kollex\Assortment\Model\BaseProductPackaging;
use Kollex\Assortment\Model\BaseProductUnit;
use Kollex\Assortment\Model\Packaging;
use Kollex\Assortment\Model\Product;
use Kollex\DataProvider\JsonDataProvider;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class JsonDataProviderTest extends TestCase
{
    private LoggerInterface $loggerMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->loggerMock = $this->createMock('\Psr\Log\LoggerInterface');
    }

    public function testCanCreateValidProducts(): void
    {
        $provider = new JsonDataProvider(__DIR__ . '/../Data/all_valid.json', $this->loggerMock);

        $products = $provider->getProducts();

        self::assertCount(4, $products);

        /** @var Product $product */
        $product = $products[0];

        self::assertInstanceOf(Product::class, $product);
        self::assertEquals(12345600001, $product->getId());
        self::assertEquals(24880602029766, $product->getGtin());
        self::assertEquals('Drinks Corp.', $product->getManufacturer());
        self::assertEquals('Soda Drink, 12x 1L', $product->getName());
        self::assertEquals(Packaging::TYPE_CASE, $product->getPackaging());
        self::assertEquals(BaseProductPackaging::TYPE_BOTTLE, $product->getBaseProductPackaging());
        self::assertEquals(BaseProductUnit::UNIT_LITER, $product->getBaseProductUnit());
        self::assertEquals(1, $product->getBaseProductAmount());
        self::assertEquals(12, $product->getBaseProductQuantity());
    }

    public function testCanCreateValidProductsWithGaps(): void
    {
        $provider = new JsonDataProvider(__DIR__ . '/../Data/not_all_valid.json', $this->loggerMock);
        $products = $provider->getProducts();

        self::assertCount(3, $products);
    }

    public function testCanNotCreateProductWithInvalidPackaging(): void
    {
        $provider = new JsonDataProvider(__DIR__ . '/../Data/invalid_packaging.json', $this->loggerMock);
        $products = $provider->getProducts();

        self::assertCount(0, $products);
    }

    public function testCanNotCreateProductWithInvalidBaseProductPackaging(): void
    {
        $provider = new JsonDataProvider(__DIR__ . '/../Data/invalid_base_product_packaging.json', $this->loggerMock);
        $products = $provider->getProducts();

        self::assertCount(0, $products);
    }

    public function testProductQuantityHasValidFloatFormat(): void
    {
        $provider = new JsonDataProvider(__DIR__ . '/../Data/all_valid.json', $this->loggerMock);

        /** @var Product $product */
        $product = $provider->getProducts()[3];

        self::assertEquals(0.75, $product->getBaseProductAmount());
    }
}
