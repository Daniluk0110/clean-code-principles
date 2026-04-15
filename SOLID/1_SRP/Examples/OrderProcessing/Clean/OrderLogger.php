<?php

declare(strict_types=1);

final class OrderLogger
{
    public function logTotal(float $total): void
    {
        file_put_contents(__DIR__ . '/orders.log', "Order total: {$total}" . PHP_EOL, FILE_APPEND);
    }
}
