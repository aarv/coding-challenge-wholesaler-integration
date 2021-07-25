<?php

declare(strict_types=1);

namespace Kollex\Service;

use Kollex\DataProvider\CsvDataProvider;
use Kollex\DataProvider\DataProviderInterface;
use Kollex\DataProvider\JsonDataProvider;
use Kollex\Exception\InvalidSourceException;
use Kollex\Validator\SourceFileValidatorInterface;

class AssortmentService
{
    public function __construct(
        private SourceFileValidatorInterface $validator
    ) {
    }

    /**
     * Facade.
     */
    public function getProducts(string $source): string
    {
        $this->validator->validateSource($source);
        $provider = $this->getProvider($source);
        $products = $provider->getProducts();

        return $this->getJsonProducts($products);
    }

    /**
     * Provider Strategy.
     */
    private function getProvider(string $source): DataProviderInterface
    {
        $extension = pathinfo($source, PATHINFO_EXTENSION);

        switch ($extension) {
            case 'csv':
                return new CsvDataProvider($source);

            case 'json':
                return new JsonDataProvider($source);

            default:
                throw new InvalidSourceException(SourceFileValidatorInterface::INVALID_EXTENSION_MESSAGE);
        }
    }

    private function getJsonProducts(array $products): string
    {
        $formattedProducts = [];

        foreach ($products as $product) {
            $formattedProducts[] = $product->toArray();
        }

        return json_encode($formattedProducts);
    }
}
