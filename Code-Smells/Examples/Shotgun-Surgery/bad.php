<?php

declare(strict_types=1);

final class OrderController
{
    public function process(string $status): void
    {
        if ($status === 'Shipped') {
            // логика отправки заказа
        } elseif ($status === 'Created') {
            // логика создания
        }
    }
}

final class EmailSender
{
    public function sendStatusEmail(string $status): void
    {
        if ($status === 'Shipped') {
            // Отправляем письмо об отправке
        } elseif ($status === 'Created') {
            // Отправляем письмо о создании
        }
    }
}

final class ReportGenerator
{
    public function getStatusColor(string $status): string
    {
        return match ($status) {
            'Shipped' => 'Green',
            'Created' => 'Blue',
            default => 'Grey',
        };
    }
}
