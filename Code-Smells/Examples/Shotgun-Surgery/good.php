<?php

declare(strict_types=1);

interface OrderStatus
{
    public function processOrder(): void;
    public function sendNotification(): void;
    public function getColor(): string;
}

final class ShippedStatus implements OrderStatus
{
    public function processOrder(): void
    {
        // логика отправки заказа
    }

    public function sendNotification(): void
    {
        // Отправляем письмо об отправке
    }

    public function getColor(): string
    {
        return 'Green';
    }
}

final class CreatedStatus implements OrderStatus
{
    public function processOrder(): void
    {
        // логика создания
    }

    public function sendNotification(): void
    {
        // Отправляем письмо о создании
    }

    public function getColor(): string
    {
        return 'Blue';
    }
}

// Теперь добавление нового статуса требует создания лишь ОДНОГО класса:
final class RefundedStatus implements OrderStatus
{
    public function processOrder(): void
    {
        // логика возврата
    }

    public function sendNotification(): void
    {
        // Отправляем письмо о возврате средств
    }

    public function getColor(): string
    {
        return 'Red';
    }
}
