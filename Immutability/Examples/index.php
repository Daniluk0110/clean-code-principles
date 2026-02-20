<?php

declare(strict_types=1);

$examples = [
    'MutableOrder.php',
    'ImmutableOrder.php',
    'AsymmetricOrder.php',
];

foreach ($examples as $file) {
    $path = __DIR__ . '/' . $file;

    echo '--- ' . $file . ' ---' . PHP_EOL;
    echo shell_exec('php ' . escapeshellarg($path)) ?? '';
    echo PHP_EOL;
}
