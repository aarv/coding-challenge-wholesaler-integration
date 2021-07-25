<?php

declare(strict_types=1);

namespace Kollex\Assortment\Model;

use Kollex\Utility\Assert;

class Packaging
{
    public const TYPE_CASE = 'CA';
    public const TYPE_BOX = 'BX';
    public const TYPE_BOTTLE = 'BO';

    private const INVALID_PACKAGING_MESSAGE = 'Invalid packaging';

    public function __construct(
        private string $type
    ) {
        Assert::enum($type, [self::TYPE_CASE, self::TYPE_BOX, self::TYPE_BOTTLE], self::INVALID_PACKAGING_MESSAGE);
    }

    public function getType(): string
    {
        return $this->type;
    }
}
