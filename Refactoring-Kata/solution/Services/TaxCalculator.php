<?php

declare(strict_types=1);

namespace RefactoringKata\Services;

use RefactoringKata\ValueObjects\Money;

final class TaxCalculator
{
    public function calculate(Money $base, float $vatRate): Money
    {
        return $base->multiply(1 + $vatRate);
    }
}
