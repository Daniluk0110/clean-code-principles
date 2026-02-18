<?php

declare(strict_types=1);

require_once __DIR__ . '/../Contracts/ProductRepository.php';
require_once __DIR__ . '/../DTO/Product.php';

final class InMemoryProductRepository implements ProductRepository
{
    /** @var Product[] */
    private array $items = [];

    public function save(Product $product): void
    {
        $this->items[] = $product;
    }

    public function all(): array
    {
        return $this->items;
    }
}
