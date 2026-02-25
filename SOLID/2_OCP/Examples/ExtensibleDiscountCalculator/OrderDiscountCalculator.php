<?php

declare(strict_types=1);

final class OrderDiscountCalculator
{
    /**
     * @param array<int, DiscountStrategyInterface> $strategies
     */
    public function __construct(private array $strategies)
    {
    }

    public function calculate(float $amount): float
    {
        $current = $amount;

        foreach ($this->strategies as $strategy) {
            $current = $strategy->apply($current);
        }

        return round($current, 2);
    }
}
