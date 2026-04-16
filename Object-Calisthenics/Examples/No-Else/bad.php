<?php

declare(strict_types=1);

namespace ObjectCalisthenics\Examples\NoElse\Bad;

final class PaymentProcessor
{
    /**
     * Проблема: Избыточное использование else делает код громоздким.
     * Мы вынуждены держать в уме состояние всех предыдущих проверок.
     */
    public function process(float $amount, float $balance, bool $isBlocked): string
    {
        if (!$isBlocked) {
            if ($balance >= $amount) {
                return "Payment successful";
            } else {
                return "Insufficient funds";
            }
        } else {
            return "Account is blocked";
        }
    }
}
