<?php

declare(strict_types=1);

namespace Kollex\Assortment\Model;

use Kollex\Utility\Assert;

class BaseProductPackaging
{
    public const TYPE_CAN = 'CN';
    public const TYPE_BOTTLE = 'BO';

    private const INVALID_PACKAGING_MESSAGE = 'Invalid BaseProduct packaging';

    public function __construct(
        private string $type
    ) {
        Assert::enum($type, [self::TYPE_BOTTLE, self::TYPE_CAN], self::INVALID_PACKAGING_MESSAGE);
    }

    public function getType(): string
    {
        return $this->type;
    }
}
