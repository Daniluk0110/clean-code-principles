<?php

declare(strict_types=1);

require_once __DIR__ . '/StripePaymentGateway.php';
require_once __DIR__ . '/PaypalPaymentGateway.php';

function processPayment(PaymentGateway $gateway, float $amount): void
{
    $result = $gateway->pay($amount);
    echo $result . PHP_EOL;
}

$amount = 99.90;

processPayment(new StripePaymentGateway(), $amount);
processPayment(new PaypalPaymentGateway(), $amount);
