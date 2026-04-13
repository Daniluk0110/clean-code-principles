<?php

declare(strict_types=1);

final class Order
{
    public function __construct(private string $status, private bool $paid) {}

    public function getStatus(): string { return $this->status; }
    public function setStatus(string $status): void { $this->status = $status; }
    
    public function isPaid(): bool { return $this->paid; }
}

final class OrderShippingService
{
    public function ship(Order $order): void
    {
        // Ask: Спрашиваем состояние
        if ($order->getStatus() !== 'new') {
            throw new RuntimeException('Cannot ship not new order');
        }

        if (!$order->isPaid()) {
            throw new RuntimeException('Cannot ship unpaid order');
        }

        // Меняем состояние снаружи
        $order->setStatus('shipped');
        echo "Order shipped! (Dirty)\n";
    }
}

$order = new Order('new', true);
$service = new OrderShippingService();
$service->ship($order);
