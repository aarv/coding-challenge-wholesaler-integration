<?php

declare(strict_types=1);

namespace Kollex\Test\Unit;

use Kollex\Assortment\Model\BaseProductPackaging;
use Kollex\Assortment\Model\BaseProductUnit;
use Kollex\Assortment\Model\Packaging;
use Kollex\Exception\InvalidDataException;
use PHPUnit\Framework\TestCase;

class ModelTest extends TestCase
{
    public function testCanNotCreateInvalidBaseProductPackaging(): void
    {
        $this->expectException(InvalidDataException::class);

        new BaseProductPackaging('Jutebeutel');
    }

    public function testCanNotCreateInvalidBaseProductUnit(): void
    {
        $this->expectException(InvalidDataException::class);

        new BaseProductUnit('qm');
    }

    public function testCanNotCreateInvalidPackaging(): void
    {
        $this->expectException(InvalidDataException::class);

        new Packaging('Cup');
    }
}