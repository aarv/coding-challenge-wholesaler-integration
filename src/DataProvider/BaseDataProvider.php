<?php

declare(strict_types=1);

namespace Kollex\DataProvider;

use Kollex\Assortment\Model\BaseProductPackaging;
use Kollex\Assortment\Model\Packaging;
use Kollex\Exception\InvalidDataException;
use Psr\Log\LoggerInterface;

class BaseDataProvider
{
    public function __construct(
        protected string $file,
        protected LoggerInterface $logger
    ) {
    }

    protected function getPackaging(string $value, string $caller): Packaging
    {
        if (str_starts_with(strtoupper($value), $caller::PACKAGING_TYPE_CASE)) {
            return new Packaging(type: Packaging::TYPE_CASE);
        }

        if (str_starts_with(strtoupper($value), $caller::PACKAGING_TYPE_BOX)) {
            return new Packaging(type: Packaging::TYPE_BOX);
        }

        if (str_starts_with(strtoupper($value), $caller::PACKAGING_TYPE_BOTTLE)) {
            return new Packaging(type: Packaging::TYPE_BOTTLE);
        }

        throw new InvalidDataException(sprintf('Invalid Packaging %s', $value));
    }

    protected function getBaseProductPackaging(string $value, string $caller): BaseProductPackaging
    {
        if (strtoupper($value) === $caller::BASE_PRODUCT_PACKAGING_TYPE_BOTTLE) {
            return new BaseProductPackaging(type: BaseProductPackaging::TYPE_BOTTLE);
        }

        if (strtoupper($value) === $caller::BASE_PRODUCT_PACKAGING_TYPE_CAN) {
            return new BaseProductPackaging(type: BaseProductPackaging::TYPE_CAN);
        }

        throw new InvalidDataException(sprintf('Invalid Base Product Packaging %s', $value));
    }
}
