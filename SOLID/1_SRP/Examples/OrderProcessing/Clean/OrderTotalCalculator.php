<?php

declare(strict_types=1);

final class OrderTotalCalculator
{
    public function calculate(array $items): float
    {
        $total = 0.0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['qty'];
        }

        return $total;
    }
}
