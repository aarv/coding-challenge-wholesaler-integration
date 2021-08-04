<?php

declare(strict_types=1);

namespace Kollex\Service;

use Kollex\DataProvider\CsvDataProvider;
use Kollex\DataProvider\DataProviderInterface;
use Kollex\DataProvider\JsonDataProvider;
use Kollex\Exception\InvalidSourceException;
use Kollex\Validator\SourceFileValidatorInterface;
use Psr\Log\LoggerInterface;

class AssortmentService
{
    public function __construct(
        private SourceFileValidatorInterface $validator,
        private LoggerInterface $logger
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

        return match ($extension){
            'csv' => new CsvDataProvider($source, $this->logger),
            'json' => new JsonDataProvider($source, $this->logger),
            default => throw new InvalidSourceException(SourceFileValidatorInterface::INVALID_EXTENSION_MESSAGE)
        };
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
