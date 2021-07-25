<?php

declare(strict_types=1);

namespace Kollex\Assortment\Model;

use Kollex\Utility\Assert;

class BaseProductUnit
{
    public const UNIT_LITER = 'LT';
    public const UNIT_GRAM = 'GR';

    private const INVALID_UNIT_MESSAGE = 'Invalid BaseProduct unit';

    public function __construct(
        private string $unit
    ) {
        Assert::enum($unit, [self::UNIT_LITER, self::UNIT_GRAM], self::INVALID_UNIT_MESSAGE);
    }

    public function getUnit(): string
    {
        return $this->unit;
    }
}
