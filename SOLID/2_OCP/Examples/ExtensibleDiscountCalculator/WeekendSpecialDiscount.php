<?php

declare(strict_types=1);

final class WeekendSpecialDiscount implements DiscountStrategyInterface
{
    public function __construct(private float $percentage, private bool $isWeekend)
    {
    }

    public function apply(float $amount): float
    {
        if (! $this->isWeekend) {
            return $amount;
        }

        $discount = $amount * ($this->percentage / 100);

        return round(max($amount - $discount, 0.0), 2);
    }
}
