<?php

declare(strict_types=1);

interface PaymentGateway
{
    public function pay(float $amount): string;
}
