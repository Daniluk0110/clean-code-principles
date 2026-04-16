<?php

declare(strict_types=1);

require_once __DIR__ . '/InMemoryStorage.php';
require_once __DIR__ . '/ReadOnlyStorage.php';

function showConfig(ReadableStorage $storage, string $path): void
{
    echo "Config: " . $storage->read($path) . PHP_EOL;
}

$storage = new InMemoryStorage();
$storage->write('app.env', 'prod');

showConfig($storage, 'app.env');

$readOnly = new ReadOnlyStorage($storage);
showConfig($readOnly, 'app.env');
