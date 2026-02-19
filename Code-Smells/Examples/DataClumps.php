<?php

declare(strict_types=1);

// ❌ Было (Плохо)
final class DeliveryService
{
    public function createShipment(string $street, string $city, string $zipCode, string $country): void
    {
        // создание отправки
    }

    public function calculateDeliveryFee(string $street, string $city, string $zipCode, string $country): int
    {
        return 0;
    }

    public function scheduleCourier(string $street, string $city, string $zipCode, string $country): void
    {
        // планирование курьера
    }
}

// ✅ Стало (Хорошо)
final class Address
{
    public function __construct(
        public readonly string $street,
        public readonly string $city,
        public readonly string $zipCode,
        public readonly string $country,
    ) {}
}

final class DeliveryServiceV2
{
    public function createShipment(Address $address): void
    {
        // создание отправки
    }

    public function calculateDeliveryFee(Address $address): int
    {
        return 0;
    }

    public function scheduleCourier(Address $address): void
    {
        // планирование курьера
    }
}
