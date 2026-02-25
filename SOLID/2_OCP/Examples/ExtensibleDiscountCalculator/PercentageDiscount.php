<?php

declare(strict_types=1);

final class PercentageDiscount implements DiscountStrategyInterface
{
    public function __construct(private float $percentage)
    {
    }

    public function apply(float $amount): float
    {
        $discount = $amount * ($this->percentage / 100);

        return round(max($amount - $discount, 0.0), 2);
    }
}
