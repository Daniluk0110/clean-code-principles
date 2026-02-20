<?php

declare(strict_types=1);

require_once __DIR__ . '/GuardClauses.php';
require_once __DIR__ . '/PaymentService.php';

function runScenario(string $title, callable $scenario): void
{
    echo "== {$title} ==\n";

    try {
        $scenario();
        echo "OK\n\n";
    } catch (Throwable $exception) {
        echo "FAIL: {$exception->getMessage()}\n\n";
    }
}

$paymentApi = new PaymentApi();
$paymentService = new PaymentServiceGood($paymentApi);

runScenario('Success: valid charge', static function () use ($paymentService): void {
    $money = Money::fromFloat(49.99, 'USD');
    $paymentService->chargeCustomer(1001, $money);
});

runScenario('Fail: invalid customerId', static function () use ($paymentService): void {
    $money = Money::fromFloat(10.00, 'USD');
    $paymentService->chargeCustomer(0, $money);
});

runScenario('Fail: negative money amount', static function (): void {
    Money::fromFloat(-5.00, 'USD');
});

runScenario('Fail: empty currency', static function (): void {
    Money::fromFloat(10.00, '');
});

runScenario('Fail: guard inArray', static function (): void {
    Guard::inArray('archived', ['pending', 'paid'], 'status');
});
