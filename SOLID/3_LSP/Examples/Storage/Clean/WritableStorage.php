<?php

declare(strict_types=1);

interface WritableStorage
{
    public function write(string $path, string $contents): void;
}
