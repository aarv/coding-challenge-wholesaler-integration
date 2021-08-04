<?php

declare(strict_types=1);

namespace Kollex\Validator;

use Kollex\DataProvider\CsvDataProvider;
use Kollex\DataProvider\JsonDataProvider;
use Kollex\Exception\InvalidMimeTypeException;
use Kollex\Exception\InvalidSourceException;
use Kollex\Utility\Assert;

class SourceFileValidator implements SourceFileValidatorInterface
{
    private const INVALID_FILE_MESSAGE = 'Unable to read the given source.';
    private const INVALID_MIME_TYPE_MESSAGE = 'Source has no valid mime type.';

    public function validateSource(string $source): void
    {
        if (!is_readable($source)) {
            throw new InvalidSourceException(self::INVALID_FILE_MESSAGE);
        }

        $this->isValidMimeType($source);
    }

    public function isValidMimeType(string $source): void
    {
        $allowedMimeType = match (pathinfo($source, PATHINFO_EXTENSION)) {
            'csv' => CsvDataProvider::VALID_MIME_TYPE,
            'json' => JsonDataProvider::VALID_MIME_TYPE,
            default => throw new InvalidSourceException(self::INVALID_EXTENSION_MESSAGE)
        };

        $fileMimeType = mime_content_type($source);

        Assert::equals($fileMimeType, $allowedMimeType, new InvalidMimeTypeException(self::INVALID_MIME_TYPE_MESSAGE));
    }
}
