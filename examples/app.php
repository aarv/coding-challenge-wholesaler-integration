<?php
/**
 * This is just a simple demo to show how to use the lib. In a real-world application you might prefer
 * using a framework or something more sophisticated.
 */
require __DIR__ . '/../vendor/autoload.php';

$file = (string) $argv[1];

$validator = new \Kollex\Validator\SourceFileValidator();
$logger = new \Monolog\Logger('assortment-service');
$logger->pushHandler(new \Monolog\Handler\StreamHandler('/var/log/assortment-service/warning.log', \Monolog\Logger::WARNING));

$service = new \Kollex\Service\AssortmentService($validator, $logger);

echo $service->getProducts($file);

