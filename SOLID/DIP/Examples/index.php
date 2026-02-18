<?php

declare(strict_types=1);

require_once __DIR__ . '/Container.php';

$container = new Container();
$userService = $container->userService();

$user = $userService->getUser(7);

echo "User: {$user['id']} {$user['name']}" . PHP_EOL;
