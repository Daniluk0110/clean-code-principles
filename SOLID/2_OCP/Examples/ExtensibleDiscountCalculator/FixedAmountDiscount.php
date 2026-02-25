<?php

declare(strict_types=1);

final class FixedAmountDiscount implements DiscountStrategyInterface
{
    public function __construct(private float $fixedAmount)
    {
    }

    public function apply(float $amount): float
    {
        return round(max($amount - $this->fixedAmount, 0.0), 2);
    }
}
