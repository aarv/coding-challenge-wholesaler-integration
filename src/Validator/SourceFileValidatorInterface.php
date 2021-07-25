<?php

declare(strict_types=1);

namespace Kollex\Validator;

interface SourceFileValidatorInterface
{
    public const INVALID_EXTENSION_MESSAGE = 'Unsupported file extension detected.';

    public function validateSource(string $source): void;

    public function isValidMimeType(string $source): void;
}
