<?php

declare(strict_types=1);

require_once __DIR__ . '/../Contracts/Notifier.php';

final class EmailNotifier implements Notifier
{
    public function __construct(private string $adminEmail) {}

    public function notify(string $message): void
    {
        echo "Email to {$this->adminEmail}: {$message}" . PHP_EOL;
    }
}
