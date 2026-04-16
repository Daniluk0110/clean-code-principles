<?php

declare(strict_types=1);

require_once __DIR__ . '/OrderTotalCalculator.php';
require_once __DIR__ . '/OrderLogger.php';
require_once __DIR__ . '/ReceiptEmailSender.php';
require_once __DIR__ . '/OrderProcessor.php';

$items = [
    ['price' => 199.90, 'qty' => 1],
    ['price' => 49.50, 'qty' => 2],
];

$processor = new OrderProcessor(
    new OrderTotalCalculator(),
    new OrderLogger(),
    new ReceiptEmailSender(),
);

$processor->process($items, 'buyer@example.com');

echo "Processed clean order\n";
