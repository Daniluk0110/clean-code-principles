<?php

declare(strict_types=1);

final class ShippingCalculator
{
    public function calculate(string $carrier, float $weight): float
    {
        return match ($carrier) {
            'DHL' => $weight * 10 + 5, // Базовая ставка + вес
            'FedEx' => $weight * 8 + 15,
            'Post' => $weight * 5,
            default => throw new InvalidArgumentException("Unknown carrier: {$carrier}"),
        };
    }
}
