<?php

declare(strict_types=1);

namespace Kollex\Test\Acceptance;

use Kollex\Service\AssortmentService;
use Kollex\Validator\SourceFileValidator;
use PHPUnit\Framework\TestCase;

class AssortmentServiceTest extends TestCase
{
    private AssortmentService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = new AssortmentService(new SourceFileValidator());
    }

    public function testHasValidOutputWithJsonSource(): void
    {
        $jsonOutput = $this->service->getProducts(__DIR__ . '/../Data/all_valid.json');
        $expectedJson = $this->getExpectedJson(__DIR__ . '/../Data/expected_output_from_json_input.json');

        self::assertEquals($expectedJson, $jsonOutput);
    }

    public function testHasValidOutputWithCsvSource(): void
    {
        $jsonOutput = $this->service->getProducts(__DIR__ . '/../Data/all_valid.csv');
        $expectedJson = $this->getExpectedJson(__DIR__ . '/../Data/expected_output_from_csv_input.json');

        self::assertEquals($expectedJson, $jsonOutput);
    }

    private function getExpectedJson(string $file):string
    {
        $expectedJson = file_get_contents($file);

        return json_encode(json_decode($expectedJson, true, 512, JSON_THROW_ON_ERROR));
    }
}