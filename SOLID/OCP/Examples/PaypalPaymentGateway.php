<?php

declare(strict_types=1);

require_once __DIR__ . '/PaymentGateway.php';

final class PaypalPaymentGateway implements PaymentGateway
{
    public function pay(float $amount): string
    {
        return "PayPal charge: {$amount}";
    }
}
