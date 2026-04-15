# OCP — Open-Closed Principle 🧱

**Расшифровка (EN):** Open-Closed Principle.  
**Расшифровка (RU):** Принцип открытости/закрытости.

**Суть:** сущности должны быть **открыты для расширения**, но **закрыты для изменения**. ✅

## Почему важно: мы добавляем новый функционал через новые классы, не ломая существующий код и тесты. 💡

### 💸 Бизнес-риски
- **Регрессионные баги:** При добавлении метода оплаты "Криптовалютой" разработчик случайно удаляет или ломает логику обработки PayPal. Пользователи не могут совершить оплату, конверсия падает.
- **Невозможность независимой работы:** Два разработчика не могут одновременно интегрировать два разных платежных шлюза в монолитный `PaymentGateway` без риска перетереть изменения друг друга.

## Теория простыми словами 📌
- Новый сценарий = новый класс, а не новая ветка `if`.
- Базовая логика не переписывается, а расширяется.
- Это снижает риск регрессий и конфликтов в команде.

## Как понять, что пора расширять 🧭
- Появился новый тип платежа/доставки/отчета.
- Логика начинает разрастаться `switch` блоками.
- Частые правки одного и того же класса.

## Запахи кода 👃
- Бесконечные `if/else` или `switch-case` по типу/статусу.
- Каждый новый кейс требует правки старого класса.
- Условные блоки повторяются в разных местах.
- «Фабрика из if-ов» в бизнес‑логике.

## Было (Плохо) ❌
```php
<?php

declare(strict_types=1);

final class PaymentGateway
{
    public function pay(string $type, float $amount): void
    {
        if ($type === 'stripe') {
            echo "Stripe: {$amount}" . PHP_EOL;
        }

        if ($type === 'paypal') {
            echo "PayPal: {$amount}" . PHP_EOL;
        }
    }
}
```

## Стало (Хорошо) ✅
```php
<?php

declare(strict_types=1);

interface PaymentGateway
{
    public function pay(float $amount): void;
}

final class StripePaymentGateway implements PaymentGateway
{
    public function pay(float $amount): void
    {
        echo "Stripe: {$amount}" . PHP_EOL;
    }
}

final class PaypalPaymentGateway implements PaymentGateway
{
    public function pay(float $amount): void
    {
        echo "PayPal: {$amount}" . PHP_EOL;
    }
}

final class PaymentProcessor
{
    public function __construct(private PaymentGateway $gateway) {}

    public function process(float $amount): void
    {
        $this->gateway->pay($amount);
    }
}
```

## Пример мини‑системы (Examples/) 🧪
В папке `Examples/PaymentProcessing/` лежат две версии кода:
- `Dirty/PaymentGateway.php` (Монолит с `if` условиями)
- `Clean/PaymentGateway.php`, `StripePaymentGateway.php`, `PaypalPaymentGateway.php`, `index.php` (Полиморфизм)

### 🧪 Как это тестировать?
В плохом варианте вам придется писать гигантский тестовый класс с кучей ветвлений, который будет проверяться каждый раз при добавлении нового провайдера.
В чистом виде (Clean), вы тестируете каждый шлюз независимо, а процессор тестируете через моки.

```php
public function testPaymentProcessorDelegatesToGateway(): void
{
    $gatewayMock = $this->createMock(PaymentGateway::class);
    $gatewayMock->expects($this->once())
                ->method('pay')
                ->with(100.0);

    $processor = new PaymentProcessor($gatewayMock);
    $processor->process(100.0);
}
```

Запуск:
```bash
php SOLID/2_OCP/Examples/PaymentProcessing/Dirty/PaymentGateway.php
php SOLID/2_OCP/Examples/PaymentProcessing/Clean/index.php
```
