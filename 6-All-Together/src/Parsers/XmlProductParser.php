<?php

declare(strict_types=1);

require_once __DIR__ . '/../Contracts/ProductParser.php';
require_once __DIR__ . '/../DTO/Product.php';

final class XmlProductParser implements ProductParser
{
    public function parse(string $raw): array
    {
        $xml = new SimpleXMLElement($raw);

        $products = [];
        foreach ($xml->product as $node) {
            $products[] = new Product(
                (string) $node['sku'],
                (string) $node->name,
                (float) $node->price,
            );
        }

        return $products;
    }
}
