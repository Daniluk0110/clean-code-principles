<?php

declare(strict_types=1);

interface ProductValidator
{
    /**
     * @return string[]
     */
    public function validate(Product $product): array;
}
