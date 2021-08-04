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
        return match (true) {
            str_starts_with(strtoupper($value), $caller::PACKAGING_TYPE_CASE) => new Packaging(type: Packaging::TYPE_CASE),
            str_starts_with(strtoupper($value), $caller::PACKAGING_TYPE_BOX) => new Packaging(type: Packaging::TYPE_BOX),
            str_starts_with(strtoupper($value), $caller::PACKAGING_TYPE_BOTTLE) => new Packaging(type: Packaging::TYPE_BOTTLE),
            default => throw new InvalidDataException(sprintf('Invalid Packaging %s', $value))
        };
    }

    protected function getBaseProductPackaging(string $value, string $caller): BaseProductPackaging
    {
        return match (true) {
            strtoupper($value) === $caller::BASE_PRODUCT_PACKAGING_TYPE_BOTTLE => new BaseProductPackaging(type: BaseProductPackaging::TYPE_BOTTLE),
            strtoupper($value) === $caller::BASE_PRODUCT_PACKAGING_TYPE_CAN => new BaseProductPackaging(type: BaseProductPackaging::TYPE_CAN),
            default => throw new InvalidDataException(sprintf('Invalid Base Product Packaging %s', $value))
        };
    }
}
