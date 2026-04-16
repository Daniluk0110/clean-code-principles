<?php

declare(strict_types=1);

final class OrderProcessor
{
    public function process(array $items, string $email): void
    {
        $total = 0.0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $this->log("Order total: {$total}");
        $this->sendEmail($email, $total);
    }

    private function log(string $message): void
    {
        file_put_contents('orders.log', $message . PHP_EOL, FILE_APPEND);
    }

    private function sendEmail(string $email, float $total): void
    {
        file_put_contents('mail.log', "Email to {$email}: total {$total}" . PHP_EOL, FILE_APPEND);
    }
}

$items = [
    ['price' => 199.90, 'qty' => 1],
    ['price' => 49.50, 'qty' => 2],
];

$processor = new OrderProcessor();
$processor->process($items, 'buyer@example.com');
echo "Processed dirty order\n";
