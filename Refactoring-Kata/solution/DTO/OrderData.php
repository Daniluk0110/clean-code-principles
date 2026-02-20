<?php

declare(strict_types=1);

namespace RefactoringKata\DTO;

use RefactoringKata\ValueObjects\Email;
use RefactoringKata\ValueObjects\Money;

final class OrderData
{
    public function __construct(
        public readonly string $userId,
        public readonly Email $email,
        public readonly string $country,
        public readonly string $shippingType,
        public readonly Money $subtotal,
        public readonly array $items,
        public readonly float $discountRate,
        public readonly float $vatRate
    ) {
        if ($this->subtotal->amount <= 0) {
            throw new \InvalidArgumentException('Subtotal must be positive.');
        }

        if (!in_array($shippingType, ['standard', 'express', 'pickup'], true)) {
            throw new \InvalidArgumentException('Unsupported shipping.');
        }
    }
}
