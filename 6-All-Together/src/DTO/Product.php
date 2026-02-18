<?php

declare(strict_types=1);

final class Product
{
    public function __construct(
        public readonly string $sku,
        public readonly string $name,
        public readonly float $price,
    ) {}
}
