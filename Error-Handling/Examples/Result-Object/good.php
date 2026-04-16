<?php

declare(strict_types=1);

namespace ErrorHandling\Examples\ResultObject\Good;

/**
 * Объект Result инкапсулирует успех или неудачу операции.
 */
final readonly class Result
{
    private function __construct(
        public bool $isSuccess,
        public ?string $error = null,
    ) {}

    public static function success(): self
    {
        return new self(true);
    }

    public static function failure(string $error): self
    {
        return new self(false, $error);
    }
}

final class TransferService
{
    /**
     * Возвращает Result вместо выброса исключения. 
     * Это делает интерфейс метода явным: он может не сработать по известным причинам.
     */
    public function transfer(float $amount, float $balance): Result
    {
        if ($amount <= 0) {
            return Result::failure("Amount must be positive");
        }

        if ($amount > $balance) {
            return Result::failure("Insufficient funds");
        }

        // Логика перевода...
        return Result::success();
    }
}

$service = new TransferService();
$result = $service->transfer(100, 50);

if (!$result->isSuccess) {
    echo "Business Error: " . $result->error . PHP_EOL;
} else {
    echo "Success!" . PHP_EOL;
}
