<?php

declare(strict_types=1);

require_once __DIR__ . '/UserRegistration.php';
require_once __DIR__ . '/ShoppingCart.php';

echo '--- CQS Demo: User Registration ---' . PHP_EOL;
$registrationService = new UserRegistrationService(new UserRepository(), new EmailService());
$user = $registrationService->register('alice@example.com', 'Alice');
echo sprintf("register() returned user %s (bad: mixes command and query)" . PHP_EOL, $user->email);

$handler = new RegisterUserHandler(new UserRepository(), new EmailService());
$handler->handle(new RegisterUserCommand('bob@example.com', 'Bob'));
echo "RegisterUserHandler::handle() returns void — чистая команда" . PHP_EOL;

echo PHP_EOL . '--- CQS Demo: Shopping Cart ---' . PHP_EOL;
$cart = new ShoppingCart();
$cart->addItem(1, new Money(1000, 'USD'));
$cart->addItem(2, new Money(2000, 'USD'));

$totalFirstCall = $cart->calculateTotal();
$totalSecondCall = $cart->calculateTotal();
echo sprintf('first query: %d cents, second query: %d cents' . PHP_EOL, $totalFirstCall->cents, $totalSecondCall->cents);

$cart->removeItem(1);
echo "removeItem() — команда без возвращаемого значения" . PHP_EOL;

echo sprintf('after command query: %d cents' . PHP_EOL, $cart->calculateTotal()->cents);
