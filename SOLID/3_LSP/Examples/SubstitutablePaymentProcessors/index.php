<?php

declare(strict_types=1);

require __DIR__ . '/PaymentProcessorInterface.php';
require __DIR__ . '/StripePaymentProcessor.php';
require __DIR__ . '/PayPalPaymentProcessor.php';
require __DIR__ . '/CloudPaymentProcessor.php';
require __DIR__ . '/SquarePaymentProcessor.php';
require __DIR__ . '/OrderPaymentService.php';

/*
 * Можно ли подставить SquarePaymentProcessor вместо других и не сломать сервис?
 * При замене ожидаемого Stripe/PayPal/Cloud на Square при крупных суммах получим исключение:
 * интерфейс обещает строку с результатом, но Square заявляет, что не поддерживает суммы > 500.
 * Это нарушение LSP: клиент OrderPaymentService (а значит и любой потребитель) ломается при подстановке.
 */

$largeAmount = 620.00;

try {
    $squareService = new OrderPaymentService(new SquarePaymentProcessor());
    echo $squareService->pay($largeAmount) . PHP_EOL;
} catch (RuntimeException $exception) {
    echo 'Square не смог обработать сумму: ' . $exception->getMessage() . PHP_EOL;
}

echo PHP_EOL . 'А вот правильная иерархия, где каждый процессор подставляется без сюрпризов:' . PHP_EOL;

$processors = [
    new StripePaymentProcessor(),
    new PayPalPaymentProcessor(),
    new CloudPaymentProcessor(),
];

foreach ($processors as $processor) {
    $service = new OrderPaymentService($processor);
    printf("%s\n", $service->pay($largeAmount));
}

/*
 * Принцип LSP: если класс реализует интерфейс, то его можно подставить вместо любого другого
 * реализаующего ту же контрактную сигнатуру без нарушения поведения клиента. Stripe, PayPal и Cloud
 * выполняют это ожидание. Square нарушает — вызывает исключение и разбивает цепочку вызовов.
 */
