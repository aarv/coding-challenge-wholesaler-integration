<?php

declare(strict_types=1);

namespace Kollex\Assortment\Model;

class Product implements ProductInterface
{
    public function __construct(
        private string $id,
        private string $gtin,
        private string $manufacturer,
        private string $name,
        private Packaging $packaging,
        private BaseProductPackaging $baseProductPackaging,
        private BaseProductUnit $baseProductUnit,
        private float $baseProductAmount,
        private int $baseProductQuantity,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getGtin(): string
    {
        return $this->gtin;
    }

    public function getManufacturer(): string
    {
        return $this->manufacturer;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPackaging(): string
    {
        return $this->packaging->getType();
    }

    public function getBaseProductPackaging(): string
    {
        return $this->baseProductPackaging->getType();
    }

    public function getBaseProductUnit(): string
    {
        return $this->baseProductUnit->getUnit();
    }

    public function getBaseProductAmount(): float
    {
        return $this->baseProductAmount;
    }

    public function getBaseProductQuantity(): int
    {
        return $this->baseProductQuantity;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'gtin' => $this->getGtin(),
            'manufacturer' => $this->getManufacturer(),
            'name' => $this->getName(),
            'packaging' => $this->getPackaging(),
            'baseProductPackaging' => $this->getBaseProductPackaging(),
            'baseProductUnit' => $this->getBaseProductUnit(),
            'baseProductAmount' => $this->getBaseProductAmount(),
            'baseProductQuantity' => $this->getBaseProductQuantity(),
        ];
    }
}
