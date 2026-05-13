<?php

declare(strict_types=1);

// ✅ Максимально простое решение, выполняющее ровно ту же задачу

final class Config
{
    public function __construct(private array $settings) {}

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->settings[$key] ?? $default;
    }
}

// Использование:
$config = new Config(['timezone' => 'UTC', 'debug' => true]);
$timezone = $config->get('timezone');
