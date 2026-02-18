<?php

declare(strict_types=1);

require_once __DIR__ . '/ReadableStorage.php';
require_once __DIR__ . '/WritableStorage.php';

final class InMemoryStorage implements ReadableStorage, WritableStorage
{
    private array $data = [];

    public function read(string $path): string
    {
        return $this->data[$path] ?? '';
    }

    public function write(string $path, string $contents): void
    {
        $this->data[$path] = $contents;
    }
}
