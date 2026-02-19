# Early Exit / Guard Clauses 🚪

Практика раннего возврата (Early Exit) устраняет вложенные `if` и делает код прямолинейным. Сначала проверяем негативные сценарии и сразу делаем `return` или бросаем исключение, а "счастливый путь" остается в конце без лишних отступов.

## Суть паттерна 📌
- Ранние проверки граничных условий.
- Немедленный `return` или `throw` при ошибке.
- Линейный happy path без вложенностей.

## Было (Плохо) ❌

Метод `processRefund($user, $order)` превращается в код-стрелу.

```php
<?php

declare(strict_types=1);

final class User
{
    public function __construct(private bool $active)
    {
    }

    public function isActive(): bool
    {
        return $this->active;
    }
}

final class Order
{
    public function __construct(private bool $paid, private bool $refunded)
    {
    }

    public function isPaid(): bool
    {
        return $this->paid;
    }

    public function isRefunded(): bool
    {
        return $this->refunded;
    }
}

final class RefundService
{
    public function processRefund(User $user, Order $order): string
    {
        if ($user->isActive()) {
            if ($order->isPaid()) {
                if (!$order->isRefunded()) {
                    return 'Refund processed';
                }

                return 'Order already refunded';
            }

            return 'Order is not paid';
        }

        return 'User is not active';
    }
}
```

## Стало (Хорошо) ✅

Ранние возвраты убирают вложенность и оставляют понятный happy path.

```php
<?php

declare(strict_types=1);

final class User
{
    public function __construct(private bool $active)
    {
    }

    public function isActive(): bool
    {
        return $this->active;
    }
}

final class Order
{
    public function __construct(private bool $paid, private bool $refunded)
    {
    }

    public function isPaid(): bool
    {
        return $this->paid;
    }

    public function isRefunded(): bool
    {
        return $this->refunded;
    }
}

final class RefundService
{
    public function processRefund(User $user, Order $order): string
    {
        if (!$user->isActive()) {
            return 'User is not active';
        }

        if (!$order->isPaid()) {
            return 'Order is not paid';
        }

        if ($order->isRefunded()) {
            return 'Order already refunded';
        }

        return 'Refund processed';
    }
}
```

## Примеры запуска ▶️

```bash
php Early-Exit/Examples/bad.php
php Early-Exit/Examples/good.php
```
