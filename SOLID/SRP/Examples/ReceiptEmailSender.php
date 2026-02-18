<?php

declare(strict_types=1);

final class ReceiptEmailSender
{
    public function send(string $email, float $total): void
    {
        $message = sprintf('Email to %s: total %.2f', $email, $total);
        file_put_contents(__DIR__ . '/mail.log', $message . PHP_EOL, FILE_APPEND);
    }
}
