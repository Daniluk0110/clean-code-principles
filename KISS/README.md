# KISS 🧩

Раздел о принципе KISS (Keep It Simple, Stupid) — борьбе с оверинжинирингом и усложнением кода там, где это не нужно. Простой код легче читать, тестировать и поддерживать.

## Суть принципа 📌
- Делай ровно то, что требуется сейчас.
- Избегай лишних уровней абстракции.
- Сначала простое решение, потом рефакторинг при необходимости.

## Почему "умный" код хуже "понятного" ⚠️
- Сложные абстракции скрывают логику, а не упрощают ее.
- Лишние уровни расширяемости усложняют отладку и внедрение новых фич.
- Чем больше умных слоев, тем больше мест, где может появиться ошибка.

### 💸 Бизнес-риски
- **Дорогая разработка простых фич:** Из-за оверинжиниринга добавление одного нового статуса заказа требует создания Фабрики, Интерфейса, Класса-стратегии и обновления сервис-провайдеров. То, что должно занимать 10 минут, занимает день.
- **Высокий порог входа:** Новым разработчикам приходится тратить недели, чтобы разобраться в "гениальной" многослойной архитектуре проекта, прежде чем они смогут приносить пользу бизнесу.

## Когда усложнение оправдано ✅
- Есть минимум две реальные реализации.
- Есть подтвержденные требования к расширяемости.
- Есть измеримая боль от текущего решения.

## Запахи кода 👃
- Использование сложных паттернов там, где хватит одного `if`.
- Злоупотребление абстракциями, фабриками и интерфейсами без реальной потребности.

## Было (Плохо) ❌

Задача простая: вернуть статус заказа текстом. Но разработчик создает фабрику, интерфейс и отдельные классы для каждого статуса.

```php
<?php

declare(strict_types=1);

interface StatusFormatterInterface
{
    public function format(string $status): string;
}

final class NewOrderFormatter implements StatusFormatterInterface
{
    public function format(string $status): string
    {
        return 'Новый заказ';
    }
}

final class PaidOrderFormatter implements StatusFormatterInterface
{
    public function format(string $status): string
    {
        return 'Оплачен';
    }
}

final class ShippedOrderFormatter implements StatusFormatterInterface
{
    public function format(string $status): string
    {
        return 'Отправлен';
    }
}

final class DeliveredOrderFormatter implements StatusFormatterInterface
{
    public function format(string $status): string
    {
        return 'Доставлен';
    }
}

final class CancelledOrderFormatter implements StatusFormatterInterface
{
    public function format(string $status): string
    {
        return 'Отменен';
    }
}

final class StatusFormatterFactory
{
    public function create(string $status): StatusFormatterInterface
    {
        return match ($status) {
            'new' => new NewOrderFormatter(),
            'paid' => new PaidOrderFormatter(),
            'shipped' => new ShippedOrderFormatter(),
            'delivered' => new DeliveredOrderFormatter(),
            'cancelled' => new CancelledOrderFormatter(),
            default => new CancelledOrderFormatter(),
        };
    }
}

final class OrderStatusService
{
    public function __construct(private StatusFormatterFactory $factory)
    {
    }

    public function getStatusLabel(string $status): string
    {
        return $this->factory->create($status)->format($status);
    }
}
```

## Стало (Хорошо) ✅

Одна простая функция с `match`, без лишних классов и фабрик.

```php
<?php

declare(strict_types=1);

final class OrderStatusService
{
    public function getStatusLabel(string $status): string
    {
        return match ($status) {
            'new' => 'Новый заказ',
            'paid' => 'Оплачен',
            'shipped' => 'Отправлен',
            'delivered' => 'Доставлен',
            'cancelled' => 'Отменен',
            default => 'Неизвестный статус',
        };
    }
}
```

### 🧪 Как это тестировать?
Тестировать сложную систему с фабриками и множеством классов - это создавать кучу моков и тестовых файлов.
Тестировать простое решение невероятно легко:

```php
public function testStatusLabelIsFormattedCorrectly(): void
{
    $service = new OrderStatusService();

    $this->assertEquals('Оплачен', $service->getStatusLabel('paid'));
    $this->assertEquals('Новый заказ', $service->getStatusLabel('new'));
    $this->assertEquals('Неизвестный статус', $service->getStatusLabel('undefined_status'));
}
```

## Примеры запуска ▶️

```bash
php KISS/Examples/ApiUrlBuilder/bad.php
php KISS/Examples/ApiUrlBuilder/good.php
```
