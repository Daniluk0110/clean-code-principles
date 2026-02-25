<?php

declare(strict_types=1);

final class SquarePaymentProcessor implements PaymentProcessorInterface
{
    public function process(float $amount): string
    {
        if ($amount > 500.0) {
            throw new RuntimeException('Square отказывается зачислять суммы больше 500');
        }

        return sprintf('Square принял %.2f, но не поддерживает большие покупки', $amount);
    }
}
