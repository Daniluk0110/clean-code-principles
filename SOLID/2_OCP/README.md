# OCP — Open-Closed Principle 🧱

**Расшифровка (EN):** Open-Closed Principle.  
**Расшифровка (RU):** Принцип открытости/закрытости.

**Суть:** сущности должны быть **открыты для расширения**, но **закрыты для изменения**. ✅

**Почему важно:** мы добавляем новый функционал через новые классы, не ломая существующий код и тесты. 💡

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
В папке `Examples/` лежат 4 файла с полностью рабочим примером без фреймворков:
- `PaymentGateway.php`
- `StripePaymentGateway.php`
- `PaypalPaymentGateway.php`
- `index.php`

Запуск:
```bash
php index.php
```
