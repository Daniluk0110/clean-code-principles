<?php

declare(strict_types=1);

namespace ObjectCalisthenics\Examples\NoElse\Good;

final class PaymentProcessor
{
    /**
     * Использование Early Exit (Guard Clauses) позволяет избавиться от else.
     * Код читается линейно, каждая проверка — это фильтр.
     */
    public function process(float $amount, float $balance, bool $isBlocked): string
    {
        if ($isBlocked) {
            return "Account is blocked";
        }

        if ($balance < $amount) {
            return "Insufficient funds";
        }

        return "Payment successful";
    }
}
