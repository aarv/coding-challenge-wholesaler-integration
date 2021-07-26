<?php
declare(strict_types=1);

namespace Kollex\Test\Unit;

use Kollex\Exception\InvalidMimeTypeException;
use Kollex\Exception\InvalidSourceException;
use Kollex\Validator\SourceFileValidator;
use PHPUnit\Framework\TestCase;

class SourceFileValidatorTest extends TestCase
{

    public function testValidatesInvalidSource(): void
    {
        $this->expectException(InvalidSourceException::class);

        $validator = new SourceFileValidator();
        $validator->validateSource(__DIR__ . '/../Data/does_not_exist.json');
    }

    public function testValidatesInvalidMimeType(): void
    {
        $this->expectException(InvalidMimeTypeException::class);

        $validator = new SourceFileValidator();
        $validator->validateSource(__DIR__ . '/../Data/invalid_type.csv');
    }
}