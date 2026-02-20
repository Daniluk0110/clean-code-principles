<?php

declare(strict_types=1);

enum OrderStatus: string
{
    case New = 'new';
    case Confirmed = 'confirmed';
    case Cancelled = 'cancelled';
    case Shipped = 'shipped';
}

final class Order
{
    public function __construct(
        public private(set) OrderStatus $status
    ) {}

    public function confirm(): void
    {
        $this->assertStatus(OrderStatus::New);
        $this->status = OrderStatus::Confirmed;
    }

    public function cancel(): void
    {
        if ($this->status === OrderStatus::Shipped) {
            throw new InvalidArgumentException('Shipped order cannot be cancelled.');
        }

        $this->status = OrderStatus::Cancelled;
    }

    public function ship(): void
    {
        $this->assertStatus(OrderStatus::Confirmed);
        $this->status = OrderStatus::Shipped;
    }

    private function assertStatus(OrderStatus $expected): void
    {
        if ($this->status !== $expected) {
            throw new InvalidArgumentException(
                sprintf('Expected status %s, got %s.', $expected->value, $this->status->value)
            );
        }
    }
}

$order = new Order(OrderStatus::New);
$order->confirm();
$order->ship();

echo $order->status->value . PHP_EOL;
