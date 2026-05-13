<?php

declare(strict_types=1);

final class Subscription
{
    public function __construct(
        private int $userId,
        private string $status,
    ) {}

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}

// ❌ Анемичная модель. Сервис "спрашивает" данные, принимает решение и обновляет объект.
final class SubscriptionService
{
    public function cancelSubscription(Subscription $subscription): void
    {
        // 1. Спрашиваем (Ask)
        if ($subscription->getStatus() === 'cancelled') {
            throw new Exception('Подписка уже отменена');
        }

        // 2. Меняем состояние снаружи
        $subscription->setStatus('cancelled');

        // 3. Отправляем email...
    }
}
