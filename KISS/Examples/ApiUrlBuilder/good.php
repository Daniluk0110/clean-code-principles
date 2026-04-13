<?php

declare(strict_types=1);

final class OrderStatusService
{
    public function getStatusLabel(string $status): string
    {
        return match ($status) {
            'new' => 'Новый заказ',
            'paid' => 'Оплачен',
            'shipped' => 'Отправлен',
            'delivered' => 'Доставлен',
            'cancelled' => 'Отменен',
            default => 'Неизвестный статус',
        };
    }
}

$service = new OrderStatusService();

echo $service->getStatusLabel('paid') . "\n";
