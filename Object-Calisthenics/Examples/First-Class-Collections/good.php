<?php

declare(strict_types=1);

namespace ObjectCalisthenics\Examples\FirstClassCollections\Good;

/**
 * Первоклассная коллекция инкапсулирует поведение набора элементов.
 * Класс содержит только массив и методы для работы с ним.
 */
final readonly class OrderItems
{
    public function __construct(
        private array $items = [],
    ) {}

    public function totalPrice(): float
    {
        return array_reduce(
            $this->items,
            fn (float $carry, array $item) => $carry + $item['price'],
            0.0
        );
    }

    public function hasDigitalItems(): bool
    {
        foreach ($this->items as $item) {
            if ($item['is_digital']) {
                return true;
            }
        }
        return false;
    }
}

final readonly class Order
{
    public function __construct(
        private OrderItems $items,
    ) {}

    public function process(): void
    {
        $total = $this->items->totalPrice();
        if ($this->items->hasDigitalItems()) {
            // ...
        }
    }
}
