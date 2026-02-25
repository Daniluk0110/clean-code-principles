<?php

declare(strict_types=1);

final class NotificationService implements UserNotifierInterface
{
    public function sendWelcome(string $email): void
    {
        file_put_contents('php://stdout', sprintf("Отправлено письмо: %s\n", $email), FILE_APPEND);
    }
}
