<?php

declare(strict_types=1);

final class OrderEmailSender
{
    public function __construct(private string $sender = 'no-reply@shop.local')
    {
    }

    /**
     * Отправляет упрощённую имитацию чека клиенту.
     *
     * @param array<int, array{price: float, quantity: int, name: string}> $items
     */
    public function sendReceipt(string $recipientEmail, string $orderId, float $total, array $items): void
    {
        $lines = array_map(
            static fn (array $item): string => sprintf("%s × %d = %.2f", $item['name'], $item['quantity'], $item['price'] * $item['quantity']),
            $items,
        );

        $message = sprintf(
            "От: %s\nКому: %s\nТема: Ваш заказ %s\nСумма: %.2f\n\nСодержимое:\n%s\n",
            $this->sender,
            $recipientEmail,
            $orderId,
            $total,
            implode("\n", $lines),
        );

        file_put_contents('php://stdout', $message . PHP_EOL, FILE_APPEND);
    }
}
