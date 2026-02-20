<?php

declare(strict_types=1);

interface TransportInterface
{
    public function send(string $message): void;
}

interface NotificationMiddlewareInterface
{
    public function process(string $message, callable $next): void;
}

final class EmailTransport implements TransportInterface
{
    public function send(string $message): void
    {
        echo "[EmailTransport] $message" . PHP_EOL;
    }
}

final class SmsTransport implements TransportInterface
{
    public function send(string $message): void
    {
        echo "[SmsTransport] $message" . PHP_EOL;
    }
}

final class PushTransport implements TransportInterface
{
    public function send(string $message): void
    {
        echo "[PushTransport] $message" . PHP_EOL;
    }
}

final class LoggingMiddleware implements NotificationMiddlewareInterface
{
    public function process(string $message, callable $next): void
    {
        echo "[Logging] start" . PHP_EOL;
        $next($message);
        echo "[Logging] end" . PHP_EOL;
    }
}

final class RetryMiddleware implements NotificationMiddlewareInterface
{
    public function process(string $message, callable $next): void
    {
        for ($attempt = 1; $attempt <= 2; $attempt++) {
            echo "[Retry] attempt #$attempt" . PHP_EOL;
            $next($message);
        }
    }
}

final class NotificationService
{
    /** @param NotificationMiddlewareInterface[] $middlewares */
    public function __construct(
        private TransportInterface $transport,
        private array $middlewares = []
    ) {}

    public function notify(string $message): void
    {
        $stack = array_reduce(
            array_reverse($this->middlewares),
            fn(callable $carry, NotificationMiddlewareInterface $middleware) => fn(string $msg) => $middleware->process($msg, $carry),
            fn(string $msg) => $this->transport->send($msg)
        );

        $stack($message);
    }
}
