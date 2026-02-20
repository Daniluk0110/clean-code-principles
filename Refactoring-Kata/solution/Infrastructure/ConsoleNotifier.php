<?php

declare(strict_types=1);

namespace RefactoringKata\Infrastructure;

use RefactoringKata\Contracts\NotifierInterface;
use RefactoringKata\Services\Order;

final class ConsoleNotifier implements NotifierInterface
{
    public function send(Order $order): void
    {
        echo sprintf(
            "Notifier: order %s for %s (%s) total %d %s" . PHP_EOL,
            $order->id,
            $order->email->value,
            $order->shippingType,
            $order->amount->amount,
            $order->amount->currency,
        );
    }
}
