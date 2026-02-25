<?php

declare(strict_types=1);

interface PaymentGatewayInterface
{
    public function charge(float $amount): string;
}
