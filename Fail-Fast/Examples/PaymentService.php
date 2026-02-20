<?php

declare(strict_types=1);

final class PaymentApi
{
    public function reserveSlot(int $customerId): void
    {
        // Pretend to call external API.
    }

    public function prepareCharge(int $customerId, float $amount): void
    {
        // Pretend to call external API.
    }

    public function charge(int $customerId, float $amount): void
    {
        // Pretend to call external API.
    }
}

// ❌ Плохо: валидации спрятаны в середине метода после вызовов API.
final class PaymentServiceBad
{
    public function __construct(private PaymentApi $paymentApi)
    {
    }

    public function chargeCustomer(int $customerId, float $amount): void
    {
        $this->paymentApi->reserveSlot($customerId);
        $this->paymentApi->prepareCharge($customerId, $amount);

        if ($amount <= 0) {
            throw new InvalidArgumentException("Amount must be positive, got: {$amount}");
        }

        $this->paymentApi->charge($customerId, $amount);
    }
}

// ✅ Хорошо: guard clauses и Money Value Object валидируют на входе.
final class Money
{
    public private(set) int $amountCents;
    public private(set) string $currency;

    private function __construct(int $amountCents, string $currency)
    {
        if ($amountCents <= 0) {
            throw new InvalidArgumentException("Field 'amount' must be a positive integer, got: {$amountCents}");
        }

        if ($currency === '') {
            throw new InvalidArgumentException("Field 'currency' must not be empty.");
        }

        $this->amountCents = $amountCents;
        $this->currency = $currency;
    }

    public static function fromFloat(float $amount, string $currency = 'USD'): self
    {
        $amountCents = (int) round($amount * 100);

        return new self($amountCents, $currency);
    }

    public function asFloat(): float
    {
        return $this->amountCents / 100;
    }
}

final class PaymentServiceGood
{
    public function __construct(private PaymentApi $paymentApi)
    {
    }

    public function chargeCustomer(int $customerId, Money $amount): void
    {
        Guard::positiveInt($customerId, 'customerId');

        $this->paymentApi->charge($customerId, $amount->asFloat());
    }
}
