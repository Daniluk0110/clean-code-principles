# Early Exit / Guard Clauses 🚪

Практика раннего возврата (Early Exit) устраняет вложенные `if` и делает код прямолинейным. Сначала проверяем негативные сценарии и сразу делаем `return` или бросаем исключение, а "счастливый путь" остается в конце без лишних отступов.

## Суть паттерна 📌
- Ранние проверки граничных условий.
- Немедленный `return` или `throw` при ошибке.
- Линейный happy path без вложенностей.

## Когда использовать ⚙️
- Валидируем входные данные.
- Отсекаем недопустимые состояния.
- Хотим сократить количество уровней вложенности.

### 💸 Бизнес-риски
- **Баги в логике из-за сложного чтения:** Когда код представляет собой "елочку" (Arrow Code) с 5 уровнями вложенности, разработчик легко может ошибиться блоком `else` и оформить возврат там, где его быть не должно.
- **Увеличение времени онбординга:** Чтение запутанного кода занимает у новых разработчиков больше времени. Они тратят часы, чтобы просто понять, при каких условиях дойдет дело до реального "полезного" действия.

## Запахи кода 👃
- Глубокая вложенность `if` (код-стрела).
- Смешение проверок и "счастливого пути" в одном блоке.

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

### 🧪 Как это тестировать?
С линейным кодом очень легко писать тесты под каждый сценарий отказа (Guard Clause), так как каждый негативный сценарий изолирован и не зависит от других `if/else`.

```php
public function testRefundFailsForInactiveUser(): void
{
    $service = new RefundService();
    $user = new User(active: false);
    $order = new Order(paid: true, refunded: false);

    $result = $service->processRefund($user, $order);

    $this->assertEquals('User is not active', $result);
}

public function testRefundProcessedSuccessfully(): void
{
    $service = new RefundService();
    $user = new User(active: true);
    $order = new Order(paid: true, refunded: false);

    $result = $service->processRefund($user, $order);

    $this->assertEquals('Refund processed', $result);
}
```

## Примеры запуска ▶️

```bash
php Early-Exit/Examples/RefundService/bad.php
php Early-Exit/Examples/RefundService/good.php
```
