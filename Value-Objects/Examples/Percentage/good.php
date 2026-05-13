<?php

declare(strict_types=1);

final class Percentage
{
    public function __construct(private float $value)
    {
        if ($value < 0 || $value > 100) {
            throw new DomainException('Процент должен быть от 0 до 100');
        }
    }

    public function toDecimal(): float
    {
        return $this->value / 100;
    }

    public function getValue(): float
    {
        return $this->value;
    }
}

final class DiscountService
{
    public function applyDiscount(float $price, Percentage $discount): float
    {
        // Никаких проверок! Объект всегда валиден.
        // И точно знаем, как его умножать, благодаря методу toDecimal()
        return $price - ($price * $discount->toDecimal());
    }
}
