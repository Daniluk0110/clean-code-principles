<?php

declare(strict_types=1);

namespace RefactoringKata\Infrastructure;

use RefactoringKata\Contracts\OrderRepositoryInterface;
use RefactoringKata\Services\Order;

final class InMemoryOrderRepository implements OrderRepositoryInterface
{
    /** @var array<string, Order> */
    private array $orders = [];

    public function save(Order $order): void
    {
        $this->orders[$order->id] = $order;
        echo "Saved order {$order->id} with {$order->amount->amount} {$order->amount->currency}" . PHP_EOL;
    }
}
