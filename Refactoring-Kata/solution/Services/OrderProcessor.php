<?php

declare(strict_types=1);

namespace RefactoringKata\Services;

use RefactoringKata\Contracts\NotifierInterface;
use RefactoringKata\Contracts\OrderRepositoryInterface;
use RefactoringKata\DTO\OrderData;
use RefactoringKata\ValueObjects\Money;

final class OrderProcessor
{
    private array $shippingModifiers = [
        'standard' => 0,
        'express' => 50,
        'pickup' => -20,
    ];

    public function __construct(
        private DiscountCalculator $discountCalculator,
        private TaxCalculator $taxCalculator,
        private OrderRepositoryInterface $repository,
        private NotifierInterface $notifier
    ) {}

    public function process(OrderData $data): void
    {
        $subtotal = $this->discountCalculator->apply($data);
        $subtotal = $this->ensurePositive($subtotal);

        $afterTax = $this->taxCalculator->calculate($subtotal, $data->vatRate);
        $total = $this->applyShippingModifiers($afterTax, $data->shippingType);

        $order = new Order(
            id: $this->generateId(),
            amount: $total,
            userId: $data->userId,
            email: $data->email,
            shippingType: $data->shippingType,
            country: $data->country
        );

        $this->repository->save($order);
        $this->notifier->send($order);
    }

    private function ensurePositive(Money $money): Money
    {
        if ($money->amount <= 0) {
            throw new \RuntimeException('Order amount must be positive.');
        }

        return $money;
    }

    private function applyShippingModifiers(Money $money, string $shippingType): Money
    {
        $modifier = $this->shippingModifiers[$shippingType] ?? 0;
        return new Money($money->amount + (int) $modifier, $money->currency);
    }

    private function generateId(): string
    {
        return (string) random_int(100000, 999999);
    }
}

final class Order
{
    public function __construct(
        public readonly string $id,
        public readonly Money $amount,
        public readonly string $userId,
        public readonly \RefactoringKata\ValueObjects\Email $email,
        public readonly string $shippingType,
        public readonly string $country
    ) {}
}
