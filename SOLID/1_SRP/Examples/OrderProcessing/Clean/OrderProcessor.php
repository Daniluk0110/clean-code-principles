<?php

declare(strict_types=1);

final class OrderProcessor
{
    public function __construct(
        private OrderTotalCalculator $calculator,
        private OrderLogger $logger,
        private ReceiptEmailSender $sender,
    ) {}

    public function process(array $items, string $email): void
    {
        $total = $this->calculator->calculate($items);
        $this->logger->logTotal($total);
        $this->sender->send($email, $total);
    }
}
