<?php

declare(strict_types=1);

final class Order
{
    public function __construct(private string $status, private bool $paid) {}

    public function ship(): void
    {
        // Логика инкапсулирована внутри
        if ($this->status !== 'new') {
            throw new DomainException('Cannot ship not new order');
        }

        if (!$this->paid) {
            throw new DomainException('Cannot ship unpaid order');
        }

        $this->status = 'shipped';
    }
    
    public function getStatus(): string
    {
        return $this->status;
    }
}

final class OrderShippingService
{
    public function shipOrder(Order $order): void
    {
        // Tell: Приказываем!
        $order->ship();
        echo "Order shipped! (Clean)\n";
    }
}

$order = new Order('new', true);
$service = new OrderShippingService();
$service->shipOrder($order);
