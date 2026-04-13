<?php

declare(strict_types=1);

final class Money
{
    private const ALLOWED_CURRENCIES = ['USD', 'EUR', 'UAH', 'RUB'];

    public function __construct(
        public private(set) int $amount,
        public private(set) string $currency,
    ) {
        if ($amount < 0) {
            throw new InvalidArgumentException('Money amount cannot be negative.');
        }

        if (!in_array($currency, self::ALLOWED_CURRENCIES, true)) {
            throw new InvalidArgumentException('Unsupported currency: ' . $currency . '.');
        }
    }

    public function add(Money $other): self
    {
        if ($this->currency !== $other->currency) {
            throw new InvalidArgumentException('Cannot add money with different currencies.');
        }

        return new self($this->amount + $other->amount, $this->currency);
    }

    public function multiply(int $factor): self
    {
        if ($factor < 0) {
            throw new InvalidArgumentException('Multiply factor cannot be negative.');
        }

        return new self($this->amount * $factor, $this->currency);
    }

    public function equals(Money $other): bool
    {
        return $this->amount === $other->amount && $this->currency === $other->currency;
    }

    public function format(): string
    {
        return $this->amount . ' ' . $this->currency;
    }
}
