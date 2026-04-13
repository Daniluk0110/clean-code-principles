<?php

declare(strict_types=1);

interface Discount
{
    public function apply(float $total): float;
}

final class TenPercentDiscount implements Discount
{
    public function apply(float $total): float
    {
        return $total * 0.9;
    }
}

final class CartService
{
    public function __construct(private ?Discount $discount = null) {}

    public function calculateTotal(float $total): float
    {
        if ($this->discount !== null) {
            return $this->discount->apply($total);
        }

        return $total;
    }
}

$cartWithDiscount = new CartService(new TenPercentDiscount());
echo "Total with discount: " . $cartWithDiscount->calculateTotal(100.0) . "\n";

$cartWithoutDiscount = new CartService(null);
echo "Total without discount: " . $cartWithoutDiscount->calculateTotal(100.0) . "\n";
