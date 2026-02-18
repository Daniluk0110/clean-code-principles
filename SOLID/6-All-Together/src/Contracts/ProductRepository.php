<?php

declare(strict_types=1);

interface ProductRepository
{
    public function save(Product $product): void;

    /**
     * @return Product[]
     */
    public function all(): array;
}
