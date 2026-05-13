# Tell, Don't Ask 🗣️

Принцип "Скажи, а не спрашивай" — это отличное дополнение к Закону Деметры (Law of Demeter) и инкапсуляции. Суть в том, что вместо того, чтобы запрашивать состояние объекта, принимать решения на основе этого состояния, а затем обновлять объект, вы должны просто "приказать" объекту выполнить действие.

## Суть правила 📌
- Данные и логика, которая работает с этими данными, должны находиться в одном месте (внутри объекта).
- Сервисы-координаторы не должны доставать данные из сущности геттерами, считать что-то, а потом возвращать результат обратно через сеттеры.

## Почему это важно ⚙️
- Идеальная инкапсуляция: объекты сами контролируют свои инварианты.
- Логика не размазывается по сотням сервисов.
- Код становится более похожим на реальный бизнес-язык (ubiquitous language).

### 💸 Бизнес-риски
- **Размытие бизнес-правил:** Если логика списания средств со счета или отмены заказа находится в сервисах, а сущности выступают лишь "мешками с данными" (Anemic Domain Model), то очень скоро в системе появятся баги: один сервис проверит баланс перед списанием, а другой, написанный стажером, забудет это сделать. Баланс уйдет в минус.
- **Сложность рефакторинга:** Изменение одной бизнес-потребности требует изменения десятка "умных" сервисов, потому что логика рассыпана повсюду.

## Запахи кода 👃
- Обилие `get...()` и `set...()` в сущностях (Anemic Domain Model).
- Блоки `if ($entity->getStatus() === ...)` раскиданные по всему проекту.

## Было (Плохо) ❌

Сервис достает данные заказа, проверяет их и меняет состояние заказа. Заказ здесь выступает просто хранилищем данных.

```php
<?php

declare(strict_types=1);

final class Order
{
    public function __construct(private string $status, private bool $paid) {}

    public function getStatus(): string { return $this->status; }
    public function setStatus(string $status): void { $this->status = $status; }
    
    public function isPaid(): bool { return $this->paid; }
}

final class OrderShippingService
{
    public function ship(Order $order): void
    {
        // Спрашиваем состояние
        if ($order->getStatus() !== 'new') {
            throw new RuntimeException('Cannot ship not new order');
        }

        if (!$order->isPaid()) {
            throw new RuntimeException('Cannot ship unpaid order');
        }

        // Меняем состояние снаружи
        $order->setStatus('shipped');
    }
}
```

## Стало (Хорошо) ✅

Сервис просто отдает команду "Отправься" (Tell), а заказ сам знает, при каких условиях это возможно.

```php
<?php

declare(strict_types=1);

final class Order
{
    public function __construct(private string $status, private bool $paid) {}

    public function ship(): void
    {
        // Логика инкапсулирована внутри
        if ($this->status !== 'new') {
            throw new DomainException('Cannot ship not new order');
        }

        if (!$this->paid) {
            throw new DomainException('Cannot ship unpaid order');
        }

        $this->status = 'shipped';
    }
    
    public function getStatus(): string
    {
        return $this->status;
    }
}

final class OrderShippingService
{
    public function shipOrder(Order $order): void
    {
        // Приказываем! Tell, Don't Ask
        $order->ship();
    }
}
```

### 🧪 Как это тестировать?
В "грязном" коде вам приходится писать интеграционные тесты для сервиса, мокая базу и прочее, просто чтобы проверить логику смены статусов.
В "чистом" коде бизнес-логика тестируется как обычный Unit-тест самой сущности, за миллисекунды:

```php
public function testOrderCannotBeShippedIfUnpaid(): void
{
    $this->expectException(DomainException::class);
    $this->expectExceptionMessage('Cannot ship unpaid order');

    $order = new Order(status: 'new', paid: false);
    $order->ship(); // Tell!
}

public function testOrderIsShippedSuccessfully(): void
{
    $order = new Order(status: 'new', paid: true);
    $order->ship();

    $this->assertEquals('shipped', $order->getStatus());
}
```

## Список примеров 🗂️

- [**Order Shipping**](Examples/OrderShipping/) — пример управления статусом заказа (описан выше).
- [**User Subscription**](Examples/User-Subscription/) — пример отмены подписки пользователя.

