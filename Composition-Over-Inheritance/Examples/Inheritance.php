<?php

declare(strict_types=1);

class BaseNotification
{
    public function send(string $message): void
    {
        echo "[Base] Sending: $message" . PHP_EOL;
    }
}

class EmailNotification extends BaseNotification
{
    public function send(string $message): void
    {
        echo "[Email] Sending: $message" . PHP_EOL;
    }
}

class PriorityEmailNotification extends EmailNotification
{
    public function send(string $message): void
    {
        echo "[Priority] Sending: $message" . PHP_EOL;
    }
}

class LoggedPriorityEmailNotification extends PriorityEmailNotification
{
    public function send(string $message): void
    {
        echo "[Logged] Start" . PHP_EOL;
        parent::send($message);
        echo "[Logged] End" . PHP_EOL;
    }
}

$notification = new LoggedPriorityEmailNotification();
$notification->send('Order #1001 ready.');

// Что если добавить SMS и логирование? Потребуется ещё один класс:
// LoggedSmsNotification extends SmsNotification extends BaseNotification, etc.
// С ростом фичей число классов взрывается, а поведение становится трудно понять.
