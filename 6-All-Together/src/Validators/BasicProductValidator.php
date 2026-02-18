<?php

declare(strict_types=1);

require_once __DIR__ . '/../Contracts/ProductValidator.php';
require_once __DIR__ . '/../DTO/Product.php';

final class BasicProductValidator implements ProductValidator
{
    public function validate(Product $product): array
    {
        $errors = [];

        if ($product->sku === '') {
            $errors[] = 'SKU is required';
        }

        if ($product->name === '') {
            $errors[] = 'Name is required';
        }

        if ($product->price <= 0) {
            $errors[] = 'Price must be greater than 0';
        }

        return $errors;
    }
}
