<?php

namespace Kollex\DataProvider;

use Kollex\Assortment\Model\BaseProductUnit;
use Kollex\Assortment\Model\Manufacturer;
use Kollex\Assortment\Model\Product;
use Kollex\Assortment\Model\ProductInterface;
use Kollex\Exception\InvalidDataException;

class JsonDataProvider extends BaseDataProvider implements DataProviderInterface
{
    public const VALID_MIME_TYPE = 'application/json';

    protected const PACKAGING_TYPE_CASE = 'CASE';
    protected const PACKAGING_TYPE_BOX = 'BOX';
    protected const PACKAGING_TYPE_BOTTLE = 'BOTTLE';

    protected const BASE_PRODUCT_PACKAGING_TYPE_CAN = 'CAN';
    protected const BASE_PRODUCT_PACKAGING_TYPE_BOTTLE = 'BOTTLE';

    /**
     * @return ProductInterface[]
     */
    public function getProducts(): array
    {
        $json = json_decode(file_get_contents($this->file), true, 512, JSON_THROW_ON_ERROR);
        $products = [];

        foreach ($json['data'] as $record) {
            if ($product = $this->createProduct($record)) {
                $products[] = $product;
            }
        }

        return $products;
    }

    private function createProduct(array $record): ?ProductInterface
    {
        try {
            $class = static::class;

            return new Product(
                id: $record['PRODUCT_IDENTIFIER'],
                gtin: $record['EAN_CODE_GTIN'],
                manufacturer: new Manufacturer($record['BRAND']),
                name: $record['NAME'],
                packaging: $this->getPackaging($record['PACKAGE'], $class),
                baseProductPackaging: $this->getBaseProductPackaging($record['VESSEL'], $class),
                baseProductUnit: new BaseProductUnit(unit: BaseProductUnit::UNIT_LITER),
                baseProductAmount: (float) str_replace(',', '.', $record['LITERS_PER_BOTTLE']),
                baseProductQuantity: (int) $record['BOTTLE_AMOUNT'],
            );
        } catch (InvalidDataException) {
            // TODO: log exception(add row).
        }

        return null;
    }
}
