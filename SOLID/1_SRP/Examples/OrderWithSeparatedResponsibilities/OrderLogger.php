<?php

declare(strict_types=1);

final class OrderLogger
{
    public function __construct(private string $logTarget = 'php://stdout')
    {
    }

    public function log(string $message): void
    {
        $timestamp = (new DateTimeImmutable())->format('Y-m-d H:i:s');
        file_put_contents($this->logTarget, sprintf("[%s] %s\n", $timestamp, $message), FILE_APPEND);
    }
}
