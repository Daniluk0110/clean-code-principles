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

final class NullDiscount implements Discount
{
    public function apply(float $total): float
    {
        return $total;
    }
}

final class CartService
{
    public function __construct(private Discount $discount) {}

    public function calculateTotal(float $total): float
    {
        return $this->discount->apply($total);
    }
}

$cartWithDiscount = new CartService(new TenPercentDiscount());
echo "Total with discount: " . $cartWithDiscount->calculateTotal(100.0) . "\n";

$cartWithoutDiscount = new CartService(new NullDiscount());
echo "Total without discount: " . $cartWithoutDiscount->calculateTotal(100.0) . "\n";
