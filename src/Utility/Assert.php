<?php

declare(strict_types=1);

namespace Kollex\Utility;

use Kollex\Exception\InvalidDataException;

class Assert
{
    private const INVALID_OPTION = 'Invalid Option';

    public static function enum(string | int $value, array $options, ?string $exceptionMessage): bool
    {
        if (!in_array($value, $options, true)) {
            throw new InvalidDataException($exceptionMessage ?? sprintf('%s %s', self::INVALID_OPTION, $value));
        }

        return true;
    }

    public static function equals(int | string $value, int | string $comparison, ?\Exception $exception = null): bool
    {
        if ($value !== $comparison) {
            throw $exception ?? new InvalidDataException(sprintf('%s has to be equal %s', $value, $comparison));
        }

        return true;
    }
}
