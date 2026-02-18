<?php

declare(strict_types=1);

final class OrderLogger
{
    public function logTotal(float $total): void
    {
        $message = sprintf('Order total: %.2f', $total);
        file_put_contents(__DIR__ . '/orders.log', $message . PHP_EOL, FILE_APPEND);
    }
}
