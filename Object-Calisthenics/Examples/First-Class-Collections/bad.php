<?php

declare(strict_types=1);

namespace ObjectCalisthenics\Examples\FirstClassCollections\Bad;

final class Order
{
    /**
     * Проблема: Логика работы с массивом (подсчет, фильтрация)
     * разбросана по классу Order или, что хуже, находится во внешнем коде.
     */
    public function __construct(
        private array $items = [],
    ) {}

    public function getTotalPrice(): float
    {
        $total = 0.0;
        foreach ($this->items as $item) {
            $total += $item['price'];
        }
        return $total;
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
