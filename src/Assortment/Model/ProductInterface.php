<?php

declare(strict_types=1);

namespace Kollex\Assortment\Model;

interface ProductInterface
{
    public function getId(): string;

    public function getManufacturer(): string;

    public function getName(): string;

    public function getPackaging(): string;

    public function getBaseProductPackaging(): string;

    public function getBaseProductUnit(): string;

    public function getBaseProductAmount(): float;

    public function getBaseProductQuantity(): int;

    public function toArray(): array;
}
