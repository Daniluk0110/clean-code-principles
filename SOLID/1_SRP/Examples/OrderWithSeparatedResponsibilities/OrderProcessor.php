<?php

declare(strict_types=1);

final class OrderProcessor
{
    public function __construct(
        private OrderTotalCalculator $calculator,
        private OrderDatabaseSaver $saver,
        private OrderLogger $logger,
        private OrderEmailSender $emailSender
    ) {
    }

    /**
     * @param array<int, array{price: float, quantity: int, name: string}> $items
     */
    public function process(array $items, string $customerEmail): array
    {
        $orderId = $this->generateOrderId();
        $total = $this->calculator->calculate($items);

        $this->logger->log(sprintf('Начата обработка заказа %s для %s', $orderId, $customerEmail));

        $this->saver->save($orderId, $items, $total);
        $this->logger->log(sprintf('Заказ %s сохранён (%.2f)', $orderId, $total));

        $this->emailSender->sendReceipt($customerEmail, $orderId, $total, $items);
        $this->logger->log(sprintf('Чек отправлен на %s', $customerEmail));

        return [
            'orderId' => $orderId,
            'total' => $total,
        ];
    }

    private function generateOrderId(): string
    {
        return bin2hex(random_bytes(5));
    }
}
