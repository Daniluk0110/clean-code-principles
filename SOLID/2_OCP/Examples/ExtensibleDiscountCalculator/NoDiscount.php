<?php

declare(strict_types=1);

final class NoDiscount implements DiscountStrategyInterface
{
    public function apply(float $amount): float
    {
        return $amount;
    }
}
