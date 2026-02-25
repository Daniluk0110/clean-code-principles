<?php

declare(strict_types=1);

final class OrderPaymentService
{
    public function __construct(private PaymentProcessorInterface $processor)
    {
    }

    public function pay(float $amount): string
    {
        $result = $this->processor->process($amount);

        return sprintf('Сервис получил подтверждение: %s', $result);
    }
}
