<?php

declare(strict_types=1);

require_once __DIR__ . '/Money.php';
require_once __DIR__ . '/Email.php';
require_once __DIR__ . '/OrderId.php';

echo "=== Value Objects Demo ===\n\n";

$orderId = OrderId::generate();
$price = new Money(1500, 'USD');
$email = new Email('client@example.com');

echo "Order ID: {$orderId->value}\n";
echo "Price: {$price->format()}\n";
echo "Email: {$email}\n";
echo "Email domain: {$email->getDomain()}\n\n";

$additional = new Money(500, 'USD');
$total = $price->add($additional);

echo "Add result: {$total->format()}\n";

echo "Multiply result: {$price->multiply(3)->format()}\n\n";

echo "=== Invalid Data Examples ===\n";

try {
    new Money(-10, 'USD');
} catch (InvalidArgumentException $e) {
    echo "Money error: {$e->getMessage()}\n";
}

try {
    new Money(100, 'GBP');
} catch (InvalidArgumentException $e) {
    echo "Currency error: {$e->getMessage()}\n";
}

try {
    $price->add(new Money(10, 'EUR'));
} catch (InvalidArgumentException $e) {
    echo "Add error: {$e->getMessage()}\n";
}

try {
    new Email('not-an-email');
} catch (InvalidArgumentException $e) {
    echo "Email error: {$e->getMessage()}\n";
}

try {
    OrderId::fromString('invalid-uuid');
} catch (InvalidArgumentException $e) {
    echo "OrderId error: {$e->getMessage()}\n";
}
