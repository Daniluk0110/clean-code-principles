<?php

declare(strict_types=1);

final class Money
{
    public function __construct(public int $cents, public string $currency) {}

    public function add(Money $other): Money
    {
        if ($this->currency !== $other->currency) {
            throw new InvalidArgumentException('Currency mismatch.');
        }

        return new Money($this->cents + $other->cents, $this->currency);
    }
}

final class ShoppingCart
{
    /** @var array<int, Money> */
    private array $items = [];

    public function addItem(int $id, Money $price): void
    {
        $this->items[$id] = $price;
    }

    /**
     * ❌ Возвращает сумму и удаляет товар — это команда и запрос одновременно.
     */
    public function removeItemAndReturnTotal(int $id): Money
    {
        unset($this->items[$id]);
        return $this->calculateTotal();
    }

    public function calculateTotal(): Money
    {
        $total = new Money(0, 'USD');
        foreach ($this->items as $price) {
            $total = $total->add($price);
        }
        return $total;
    }

    // ✅ Команда без результата
    public function removeItem(int $id): void
    {
        unset($this->items[$id]);
    }
}
