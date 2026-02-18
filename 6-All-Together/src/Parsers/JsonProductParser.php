<?php

declare(strict_types=1);

require_once __DIR__ . '/../Contracts/ProductParser.php';
require_once __DIR__ . '/../DTO/Product.php';

final class JsonProductParser implements ProductParser
{
    public function parse(string $raw): array
    {
        $data = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);

        $products = [];
        foreach ($data['products'] ?? [] as $item) {
            $products[] = new Product(
                (string) ($item['sku'] ?? ''),
                (string) ($item['name'] ?? ''),
                (float) ($item['price'] ?? 0),
            );
        }

        return $products;
    }
}
