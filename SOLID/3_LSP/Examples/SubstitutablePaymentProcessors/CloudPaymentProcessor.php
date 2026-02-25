<?php

declare(strict_types=1);

final class CloudPaymentProcessor implements PaymentProcessorInterface
{
    public function process(float $amount): string
    {
        return sprintf('CloudPayments зафиксировал %.2f и списал средства', $amount);
    }
}
