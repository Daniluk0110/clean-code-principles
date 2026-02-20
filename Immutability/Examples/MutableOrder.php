<?php

declare(strict_types=1);

final class Order
{
    public function __construct(
        public int $id,
        public string $status,
        public float $amount
    ) {}

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}

final class PaymentService
{
    public function capture(Order $order): void
    {
        $order->setStatus('paid');
    }
}

final class NotificationService
{
    public function send(Order $order): string
    {
        return sprintf('Notify: order #%d is %s', $order->id, $order->status);
    }
}

$order = new Order(1001, 'new', 150.00);
$payment = new PaymentService();
$notifier = new NotificationService();

$payment->capture($order); // неожиданно меняет состояние

// Второй сервис получает уже изменённый объект.
echo $notifier->send($order) . PHP_EOL;
