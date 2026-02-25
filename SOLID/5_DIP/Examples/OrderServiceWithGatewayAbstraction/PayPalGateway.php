<?php

declare(strict_types=1);

final class PayPalGateway implements PaymentGatewayInterface
{
    public function charge(float $amount): string
    {
        return sprintf('PayPal инициировал платёж %.2f', $amount);
    }
}
