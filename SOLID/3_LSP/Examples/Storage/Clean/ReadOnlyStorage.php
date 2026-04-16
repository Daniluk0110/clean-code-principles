<?php

declare(strict_types=1);

require_once __DIR__ . '/ReadableStorage.php';

final class ReadOnlyStorage implements ReadableStorage
{
    public function __construct(private ReadableStorage $storage) {}

    public function read(string $path): string
    {
        return $this->storage->read($path);
    }
}
