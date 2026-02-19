# KISS

Раздел о принципе KISS (Keep It Simple, Stupid) — борьбе с оверинжинирингом и усложнением кода там, где это не нужно. Простой код легче читать, тестировать и поддерживать, а значит дешевле в изменениях и надежнее в эксплуатации.

## Почему "умный" код хуже "понятного"
- Сложные абстракции скрывают логику, а не упрощают ее.
- Лишние уровни расширяемости усложняют отладку и внедрение новых фич.
- Чем больше умных слоев, тем больше мест, где может появиться ошибка.

## Запахи кода
- Использование сложных паттернов там, где хватит одного `if`.
- Злоупотребление абстракциями, фабриками и интерфейсами без реальной потребности.

## Было (Плохо)

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

## Стало (Хорошо)

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

## Примеры запуска

```bash
php KISS/Examples/bad.php
php KISS/Examples/good.php
```
