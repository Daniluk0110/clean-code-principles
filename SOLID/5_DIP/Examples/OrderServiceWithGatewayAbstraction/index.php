<?php

declare(strict_types=1);

require __DIR__ . '/PaymentGatewayInterface.php';
require __DIR__ . '/StripeGateway.php';
require __DIR__ . '/PayPalGateway.php';
require __DIR__ . '/FakeGateway.php';
require __DIR__ . '/OrderService.php';

/*
 * Плохой подход: OrderService внутри делает new StripeGateway(), то есть высокоуровневый модуль
 * захардкожен к конкретной реализации шлюза. Когда нужно переключиться на PayPal, придётся
 * править сам OrderService.
 */

final class LegacyOrderService
{
    public function submit(float $amount): string
    {
        $gateway = new StripeGateway();

        return $gateway->charge($amount);
    }
}

$amount = 450.00;

$legacy = new LegacyOrderService();
echo "Legacy: " . $legacy->submit($amount) . PHP_EOL;

/*
 * Правильный вариант: высокоуровневый сервис зависит только от абстракции (PaymentGatewayInterface).
 * И высокоуровневые, и низкоуровневые модули зависят от интерфейса. Именно так работает Laravel Container.
 */

$stringGateway = new OrderService(new StripeGateway());
echo "Stripe (через DIP): " . $stringGateway->submit($amount) . PHP_EOL;

$paypalGateway = new OrderService(new PayPalGateway());
echo "PayPal (через DIP): " . $paypalGateway->submit($amount) . PHP_EOL;

$fakeGateway = new OrderService(new FakeGateway());
echo "Fake (тестовый): " . $fakeGateway->submit($amount) . PHP_EOL;
