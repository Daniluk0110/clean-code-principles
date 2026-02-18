<?php

declare(strict_types=1);

interface ReadableStorage
{
    public function read(string $path): string;
}
