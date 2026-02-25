<?php

declare(strict_types=1);

interface PaymentProcessorInterface
{
    public function process(float $amount): string;
}
