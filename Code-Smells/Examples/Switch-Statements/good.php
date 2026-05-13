<?php

declare(strict_types=1);

interface ShippingStrategy
{
    public function calculate(float $weight): float;
}

final class DhlShipping implements ShippingStrategy
{
    public function calculate(float $weight): float
    {
        return $weight * 10 + 5;
    }
}

final class FedExShipping implements ShippingStrategy
{
    public function calculate(float $weight): float
    {
        return $weight * 8 + 15;
    }
}

final class PostShipping implements ShippingStrategy
{
    public function calculate(float $weight): float
    {
        return $weight * 5;
    }
}

final class ShippingCalculator
{
    public function __construct(private ShippingStrategy $strategy) {}

    public function calculate(float $weight): float
    {
        return $this->strategy->calculate($weight);
    }
}
