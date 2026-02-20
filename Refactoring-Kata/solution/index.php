<?php

declare(strict_types=1);

use RefactoringKata\Contracts\NotifierInterface;
use RefactoringKata\Infrastructure\ConsoleNotifier;
use RefactoringKata\Infrastructure\InMemoryOrderRepository;
use RefactoringKata\Services\DiscountCalculator;
use RefactoringKata\Services\OrderProcessor;
use RefactoringKata\Services\TaxCalculator;
use RefactoringKata\ValueObjects\Email;
use RefactoringKata\ValueObjects\Money;
use RefactoringKata\DTO\OrderData;

require_once __DIR__ . '/DTO/OrderData.php';
require_once __DIR__ . '/ValueObjects/Money.php';
require_once __DIR__ . '/ValueObjects/Email.php';
require_once __DIR__ . '/Contracts/OrderRepositoryInterface.php';
require_once __DIR__ . '/Contracts/NotifierInterface.php';
require_once __DIR__ . '/Services/DiscountCalculator.php';
require_once __DIR__ . '/Services/TaxCalculator.php';
require_once __DIR__ . '/Services/OrderProcessor.php';
require_once __DIR__ . '/Infrastructure/InMemoryOrderRepository.php';
require_once __DIR__ . '/Infrastructure/ConsoleNotifier.php';

$discount = new DiscountCalculator();
$tax = new TaxCalculator();
$repository = new InMemoryOrderRepository();
$notifier = new ConsoleNotifier();

$processor = new OrderProcessor($discount, $tax, $repository, $notifier);

$order = new OrderData(
    userId: 'user-123',
    email: new Email('customer@example.com'),
    country: 'RU',
    shippingType: 'express',
    subtotal: new Money(150000, 'RUB'),
    items: [],
    discountRate: 0.15,
    vatRate: 0.18,
);

$processor->process($order);
