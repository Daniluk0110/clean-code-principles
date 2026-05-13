<?php

declare(strict_types=1);

final class Subscription
{
    public function __construct(
        private int $userId,
        private string $status,
    ) {}

    // ✅ Инкапсуляция логики
    public function cancel(): void
    {
        if ($this->status === 'cancelled') {
            throw new DomainException('Подписка уже отменена');
        }

        $this->status = 'cancelled';
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}

// ✅ Tell, Don't Ask. Сервис отдает приказ объекту.
final class SubscriptionService
{
    public function cancelSubscription(Subscription $subscription): void
    {
        // 1. Приказываем (Tell)
        $subscription->cancel();

        // 2. Отправляем email...
    }
}
