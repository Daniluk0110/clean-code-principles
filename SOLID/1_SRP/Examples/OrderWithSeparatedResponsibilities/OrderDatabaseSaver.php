<?php

declare(strict_types=1);

final class OrderDatabaseSaver
{
    public function __construct(private string $storagePath)
    {
    }

    /**
     * Сохраняет запись заказа в JSON-имитацию базы.
     *
     * @param array<int, array{price: float, quantity: int, name: string}> $items
     */
    public function save(string $orderId, array $items, float $total): void
    {
        $record = [
            'id' => $orderId,
            'items' => $items,
            'total' => $total,
            'created_at' => (new DateTimeImmutable())->format(DATE_ATOM),
        ];

        $existing = [];

        if (is_file($this->storagePath)) {
            $content = file_get_contents($this->storagePath);
            if ($content !== false) {
                $decoded = json_decode($content, true);
                if (is_array($decoded)) {
                    $existing = $decoded;
                }
            }
        }

        $existing[] = $record;

        file_put_contents($this->storagePath, json_encode($existing, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
