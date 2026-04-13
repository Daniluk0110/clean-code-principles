<?php

declare(strict_types=1);

final class User
{
    public function __construct(private bool $active)
    {
    }

    public function isActive(): bool
    {
        return $this->active;
    }
}

final class Order
{
    public function __construct(private bool $paid, private bool $refunded)
    {
    }

    public function isPaid(): bool
    {
        return $this->paid;
    }

    public function isRefunded(): bool
    {
        return $this->refunded;
    }
}

final class RefundService
{
    public function processRefund(User $user, Order $order): string
    {
        if ($user->isActive()) {
            if ($order->isPaid()) {
                if (!$order->isRefunded()) {
                    return 'Refund processed';
                }

                return 'Order already refunded';
            }

            return 'Order is not paid';
        }

        return 'User is not active';
    }
}

$service = new RefundService();
$user = new User(true);
$order = new Order(true, false);

echo $service->processRefund($user, $order)."\n";
