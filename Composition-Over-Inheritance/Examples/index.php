<?php

declare(strict_types=1);

require_once __DIR__ . '/Inheritance.php';
require_once __DIR__ . '/Composition.php';
require_once __DIR__ . '/PricingStrategy.php';

// Демонстрируем композицию критичного конфигурационного полотна.
$emailService = new NotificationService(
    new EmailTransport(),
    [new LoggingMiddleware()]
);
$emailService->notify('Order #1001 confirmed.');

$smsService = new NotificationService(new SmsTransport());
$smsService->notify('Payment reminder for Order #1002.');

$pushService = new NotificationService(new PushTransport(), [new RetryMiddleware()]);
$pushService->notify('Shipment #3000 has left the warehouse.');

echo PHP_EOL;

echo 'Pricing with Strategy:' . PHP_EOL;
$base = new Money(50000, 'USD');
$regular = new UserWithStrategy($base, new RegularPricing());
$premium = new UserWithStrategy($base, new PremiumPricing());
$corporate = new UserWithStrategy($base, new CorporatePricing());

echo sprintf('Regular: %d cents' . PHP_EOL, $regular->getPrice()->cents);
echo sprintf('Premium: %d cents' . PHP_EOL, $premium->getPrice()->cents);
echo sprintf('Corporate: %d cents' . PHP_EOL, $corporate->getPrice()->cents);
