<?php

declare(strict_types=1);

final class OrderTotalCalculator
{
    /**
     * @param array<int, array{price: float, quantity: int}> $items
     */
    public function calculate(array $items): float
    {
        $total = 0.0;

        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return round($total, 2);
    }
}
