<?php

declare(strict_types=1);

namespace Kollex\DataProvider;

use Kollex\Assortment\Model\BaseProductUnit;
use Kollex\Assortment\Model\Manufacturer;
use Kollex\Assortment\Model\Product;
use Kollex\Assortment\Model\ProductInterface;
use Kollex\Exception\InvalidDataException;

class CsvDataProvider extends BaseDataProvider implements DataProviderInterface
{
    public const VALID_MIME_TYPE = 'text/plain';

    protected const PACKAGING_TYPE_CASE = 'CASE';
    protected const PACKAGING_TYPE_BOX = 'BOX';
    protected const PACKAGING_TYPE_BOTTLE = 'BOTTLE';

    protected const BASE_PRODUCT_PACKAGING_TYPE_CAN = 'CAN';
    protected const BASE_PRODUCT_PACKAGING_TYPE_BOTTLE = 'BOTTLE';

    protected const UNIT_TYPE_LITER = 'l';
    protected const UNIT_TYPE_GRAM = 'g'; // TODO: verify

    private const CSV_SEPARATOR = ';';

    private bool $ignoreFirstLine = true;

    /**
     * @return ProductInterface[]
     */
    public function getProducts(): array
    {
        $file = fopen($this->file, 'r');
        $currentLine = 0;
        $products = [];

        while (($row = fgetcsv($file, 0, self::CSV_SEPARATOR)) !== false) {
            $currentLine++;

            if ($this->ignoreFirstLine && $currentLine === 1) {
                continue;
            }

            if ($product = $this->createProduct($row)) {
                $products[] = $product;
            }
        }

        fclose($file);

        return $products;
    }

    private function createProduct(array $row): ?ProductInterface
    {
        try {
            $class = static::class;

            return new Product(
                id: $row[0],
                gtin: $row[1],
                manufacturer: new Manufacturer($row[2]),
                name: $row[3],
                packaging: $this->getPackaging($row[5], $class),
                baseProductPackaging: $this->getBaseProductPackaging($row[7], $class),
                baseProductUnit: $this->getBaseProductUnit($row[8]),
                baseProductAmount: (float) substr($row[8], 0, -1),
                baseProductQuantity: (int) $row[9],
            );
        } catch (InvalidDataException) {
            // TODO: log exception(add row).
        }

        return null;
    }

    private function getBaseProductUnit(string $value): BaseProductUnit
    {
        $unit = substr($value, -1);

        if ($unit === self::UNIT_TYPE_LITER) {
            return new BaseProductUnit(unit: BaseProductUnit::UNIT_LITER);
        }

        if ($unit === self::UNIT_TYPE_GRAM) {
            return new BaseProductUnit(unit: BaseProductUnit::UNIT_GRAM);
        }

        throw new InvalidDataException(sprintf('Invalid Base Product Unit %s', $value));
    }
}
