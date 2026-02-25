<?php

declare(strict_types=1);

final class StripeGateway implements PaymentGatewayInterface
{
    public function charge(float $amount): string
    {
        return sprintf('Stripe снял %.2f с карты', $amount);
    }
}
