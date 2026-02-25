<?php

declare(strict_types=1);

final class StripePaymentProcessor implements PaymentProcessorInterface
{
    public function process(float $amount): string
    {
        return sprintf('Stripe поднял %.2f и подтвердил платёж', $amount);
    }
}
