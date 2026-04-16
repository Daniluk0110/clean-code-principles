<?php

declare(strict_types=1);

final class PaymentGateway
{
    public function pay(string $type, float $amount): void
    {
        if ($type === 'stripe') {
            echo "Stripe: {$amount}" . PHP_EOL;
        }

        if ($type === 'paypal') {
            echo "PayPal: {$amount}" . PHP_EOL;
        }
    }
}

$gateway = new PaymentGateway();
$gateway->pay('stripe', 100.0);
$gateway->pay('paypal', 50.0);
