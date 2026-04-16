<?php

declare(strict_types=1);

namespace ErrorHandling\Examples\ResultObject\Bad;

use Exception;

final class TransferService
{
    /**
     * Использование исключений для ожидаемых бизнес-ошибок (например, нехватка средств).
     * Проблема: Исключения дороги и прерывают поток выполнения, заставляя использовать try-catch
     * для обычных условий, которые не являются критическим сбоем.
     */
    public function transfer(float $amount, float $balance): void
    {
        if ($amount <= 0) {
            throw new Exception("Amount must be positive");
        }

        if ($amount > $balance) {
            throw new Exception("Insufficient funds");
        }

        echo "Transferred: {$amount}" . PHP_EOL;
    }
}

$service = new TransferService();

try {
    $service->transfer(100, 50);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
