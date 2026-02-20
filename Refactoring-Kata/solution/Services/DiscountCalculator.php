<?php

declare(strict_types=1);

namespace RefactoringKata\Services;

use RefactoringKata\DTO\OrderData;
use RefactoringKata\ValueObjects\Money;

final class DiscountCalculator
{
    public function apply(OrderData $data): Money
    {
        $rate = $data->discountRate;
        return $data->subtotal->multiply(1 - $rate);
    }
}
