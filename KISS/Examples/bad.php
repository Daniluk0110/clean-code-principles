<?php

declare(strict_types=1);

interface StatusFormatterInterface
{
    public function format(string $status): string;
}

final class NewOrderFormatter implements StatusFormatterInterface
{
    public function format(string $status): string
    {
        return 'Новый заказ';
    }
}

final class PaidOrderFormatter implements StatusFormatterInterface
{
    public function format(string $status): string
    {
        return 'Оплачен';
    }
}

final class ShippedOrderFormatter implements StatusFormatterInterface
{
    public function format(string $status): string
    {
        return 'Отправлен';
    }
}

final class DeliveredOrderFormatter implements StatusFormatterInterface
{
    public function format(string $status): string
    {
        return 'Доставлен';
    }
}

final class CancelledOrderFormatter implements StatusFormatterInterface
{
    public function format(string $status): string
    {
        return 'Отменен';
    }
}

final class StatusFormatterFactory
{
    public function create(string $status): StatusFormatterInterface
    {
        return match ($status) {
            'new' => new NewOrderFormatter(),
            'paid' => new PaidOrderFormatter(),
            'shipped' => new ShippedOrderFormatter(),
            'delivered' => new DeliveredOrderFormatter(),
            'cancelled' => new CancelledOrderFormatter(),
            default => new CancelledOrderFormatter(),
        };
    }
}

final class OrderStatusService
{
    public function __construct(private StatusFormatterFactory $factory)
    {
    }

    public function getStatusLabel(string $status): string
    {
        return $this->factory->create($status)->format($status);
    }
}

$service = new OrderStatusService(new StatusFormatterFactory());

echo $service->getStatusLabel('paid') . "\n";
