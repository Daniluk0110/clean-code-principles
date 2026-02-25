<?php

declare(strict_types=1);

final class OrderService
{
    public function __construct(private PaymentGatewayInterface $gateway)
    {
    }

    public function submit(float $amount): string
    {
        return $this->gateway->charge($amount);
    }
}
