<?php

declare(strict_types=1);

final class PayPalPaymentProcessor implements PaymentProcessorInterface
{
    public function process(float $amount): string
    {
        return sprintf('PayPal оплатил %.2f и выдал чек', $amount);
    }
}
