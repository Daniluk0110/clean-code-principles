<?php

declare(strict_types=1);

// ❌ Было (Плохо)
final class InvoiceService
{
    public function createInvoice(
        int $userId,
        float $amount,
        string $currency,
        string $email,
        string $status
    ): void {
        // данные не валидируются, логика размазана
    }
}

// ✅ Стало (Хорошо)
final class InvoiceData
{
    public function __construct(
        public readonly int $userId,
        public readonly string $email,
        public readonly string $status,
    ) {}
}

final class Money
{
    public function __construct(
        public readonly int $amount,
        public readonly string $currency,
    ) {}
}

final class InvoiceServiceV2
{
    public function createInvoice(InvoiceData $data, Money $total): void
    {
        // валидация и поведение внутри объектов
    }
}
