<?php

declare(strict_types=1);

// ❌ Было (Плохо)
final class OrderGodService
{
    public function placeOrder(int $orderId, int $userId, int $amount): void
    {
        $discount = $this->calculateDiscount($userId, $amount);
        $this->chargePayment($orderId, $amount - $discount);
        $this->sendEmail($userId, $orderId);
        $this->writeLog($orderId);
        $this->generatePdf($orderId);
        $this->updateWarehouse($orderId);
    }

    private function calculateDiscount(int $userId, int $amount): int
    {
        return $amount > 10000 ? 1000 : 0;
    }

    private function chargePayment(int $orderId, int $amount): void
    {
        // платежная интеграция
    }

    private function sendEmail(int $userId, int $orderId): void
    {
        // SMTP логика
    }

    private function writeLog(int $orderId): void
    {
        // запись лога
    }

    private function generatePdf(int $orderId): void
    {
        // генерация PDF
    }

    private function updateWarehouse(int $orderId): void
    {
        // обновление склада
    }
}

// ✅ Стало (Хорошо)
final class DiscountCalculator
{
    public function calculate(int $userId, int $amount): int
    {
        return $amount > 10000 ? 1000 : 0;
    }
}

final class OrderNotifier
{
    public function sendConfirmation(int $userId, int $orderId): void
    {
        // отправка письма
    }
}

final class WarehouseService
{
    public function reserveItems(int $orderId): void
    {
        // резерв на складе
    }
}

final class OrderService
{
    public function __construct(
        private DiscountCalculator $discounts,
        private OrderNotifier $notifier,
        private WarehouseService $warehouse,
    ) {}

    public function placeOrder(int $orderId, int $userId, int $amount): void
    {
        $discount = $this->discounts->calculate($userId, $amount);
        $this->chargePayment($orderId, $amount - $discount);
        $this->notifier->sendConfirmation($userId, $orderId);
        $this->warehouse->reserveItems($orderId);
    }

    private function chargePayment(int $orderId, int $amount): void
    {
        // платежная интеграция
    }
}
