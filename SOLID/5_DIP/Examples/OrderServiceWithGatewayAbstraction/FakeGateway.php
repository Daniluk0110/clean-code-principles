<?php

declare(strict_types=1);

final class FakeGateway implements PaymentGatewayInterface
{
    public function charge(float $amount): string
    {
        return sprintf('Фейковый шлюз имитирует списание %.2f', $amount);
    }
}
