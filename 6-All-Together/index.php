<?php

declare(strict_types=1);

require_once __DIR__ . '/src/DTO/Product.php';
require_once __DIR__ . '/src/DTO/ImportReport.php';
require_once __DIR__ . '/src/Contracts/ProductParser.php';
require_once __DIR__ . '/src/Contracts/ProductValidator.php';
require_once __DIR__ . '/src/Contracts/ProductRepository.php';
require_once __DIR__ . '/src/Contracts/Notifier.php';
require_once __DIR__ . '/src/Parsers/JsonProductParser.php';
require_once __DIR__ . '/src/Parsers/XmlProductParser.php';
require_once __DIR__ . '/src/Validators/BasicProductValidator.php';
require_once __DIR__ . '/src/Repositories/InMemoryProductRepository.php';
require_once __DIR__ . '/src/Notifiers/EmailNotifier.php';
require_once __DIR__ . '/src/Services/ProductImportService.php';

$repository = new InMemoryProductRepository();
$validator = new BasicProductValidator();
$notifier = new EmailNotifier('admin@example.com');

$json = json_encode([
    'products' => [
        ['sku' => 'A-100', 'name' => 'Keyboard', 'price' => 49.9],
        ['sku' => '', 'name' => 'Broken item', 'price' => 0],
    ],
], JSON_THROW_ON_ERROR);

$xml = <<<XML
<products>
    <product sku="B-200">
        <name>Mouse</name>
        <price>19.5</price>
    </product>
    <product sku="C-300">
        <name></name>
        <price>10</price>
    </product>
</products>
XML;

$jsonImport = new ProductImportService(
    new JsonProductParser(),
    $validator,
    $repository,
    $notifier,
);

$xmlImport = new ProductImportService(
    new XmlProductParser(),
    $validator,
    $repository,
    $notifier,
);

$jsonImport->import($json);
$xmlImport->import($xml);

foreach ($repository->all() as $product) {
    echo "Saved: {$product->sku} {$product->name} {$product->price}" . PHP_EOL;
}
