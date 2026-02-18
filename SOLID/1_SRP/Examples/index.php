<?php

declare(strict_types=1);

require_once __DIR__ . '/OrderTotalCalculator.php';
require_once __DIR__ . '/OrderLogger.php';
require_once __DIR__ . '/ReceiptEmailSender.php';

final class OrderProcessor
{
    public function __construct(
        private OrderTotalCalculator $calculator,
        private OrderLogger $logger,
        private ReceiptEmailSender $sender,
    ) {}

    /** @param array<int, array{price: float, qty: int}> $items */
    public function process(array $items, string $email): float
    {
        $total = $this->calculator->calculate($items);
        $this->logger->logTotal($total);
        $this->sender->send($email, $total);

        return $total;
    }
}

$items = [
    ['price' => 199.90, 'qty' => 1],
    ['price' => 49.50, 'qty' => 2],
];

$processor = new OrderProcessor(
    new OrderTotalCalculator(),
    new OrderLogger(),
    new ReceiptEmailSender(),
);

$total = $processor->process($items, 'buyer@example.com');

echo 'Processed order. Total: ' . number_format($total, 2) . PHP_EOL;
