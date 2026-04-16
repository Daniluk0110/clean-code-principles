<?php

declare(strict_types=1);

final class ReceiptEmailSender
{
    public function send(string $email, float $total): void
    {
        file_put_contents(__DIR__ . '/mail.log', "Email to {$email}: total {$total}" . PHP_EOL, FILE_APPEND);
    }
}
