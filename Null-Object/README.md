# Null Object Pattern 👻

Паттерн Null Object позволяет избавиться от бесконечных проверок на `null` (`if ($obj !== null)`). Суть в том, чтобы вместо возвращения `null` (который ничего не умеет и вызывает ошибки), возвращать специальный объект-заглушку, который реализует тот же интерфейс, но ничего не делает (или реализует дефолтное безопасное поведение).

## Суть паттерна 📌
- Создать класс, реализующий интерфейс, который ничего не делает.
- Возвращать этот объект вместо `null`.
- Вызывающий код может смело вызывать методы объекта, не боясь `NullPointerException` (в PHP - `Error на null`).

## Почему это важно ⚙️
- Убираются визуальный шум и дублирование проверок `if ($foo)`.
- Код становится более полиморфным (код просто доверяет контракту).
- Уменьшается риск случайного падения приложения из-за забытой проверки на null.

### 💸 Бизнес-риски
- **Fatal Error в проде:** Кто-то забыл обернуть вызов в `if ($discount !== null)`, и страница чекаута упала с ошибкой `Call to a member function apply() on null`. Пользователи не могут купить товар.
- **Цикломатическая сложность:** Код быстро превращается в "елочку" из `if` и `else`, его невозможно читать и ревьюить, что замедляет выпуск новых фич.

## Запахи кода 👃
- Десятки проверок `if ($obj !== null)` или `if ($obj instanceof SomeClass)`.
- Использование оператора `?->` почти на каждом вызове метода.

## Было (Плохо) ❌

Сервис вынужден проверять, существует ли скидка, прежде чем её применить.

```php
<?php

declare(strict_types=1);

interface Discount
{
    public function apply(float $total): float;
}

final class TenPercentDiscount implements Discount
{
    public function apply(float $total): float
    {
        return $total * 0.9;
    }
}

final class CartService
{
    // Скидка может быть null
    public function __construct(private ?Discount $discount = null) {}

    public function calculateTotal(float $total): float
    {
        // Постоянная проверка на null
        if ($this->discount !== null) {
            return $this->discount->apply($total);
        }

        return $total;
    }
}
```

## Стало (Хорошо) ✅

Вместо `null` используется `NullDiscount`, который просто возвращает исходную сумму. Код `CartService` становится линейным.

```php
<?php

declare(strict_types=1);

interface Discount
{
    public function apply(float $total): float;
}

final class TenPercentDiscount implements Discount
{
    public function apply(float $total): float
    {
        return $total * 0.9;
    }
}

// Тот самый Null Object
final class NullDiscount implements Discount
{
    public function apply(float $total): float
    {
        // Ничего не меняет
        return $total;
    }
}

final class CartService
{
    // Зависимость всегда есть (никогда не null)
    public function __construct(private Discount $discount) {}

    public function calculateTotal(float $total): float
    {
        // Вызываем смело!
        return $this->discount->apply($total);
    }
}
```

### 🧪 Как это тестировать?
Тестировать Null Object так же просто, как и любую другую реализацию.

```php
public function testCartTotalWithNullDiscount(): void
{
    $cart = new CartService(new NullDiscount());
    $total = $cart->calculateTotal(100.0);
    
    $this->assertEquals(100.0, $total);
}

public function testCartTotalWithTenPercentDiscount(): void
{
    $cart = new CartService(new TenPercentDiscount());
    $total = $cart->calculateTotal(100.0);
    
    $this->assertEquals(90.0, $total);
}
```

## Примеры запуска ▶️

```bash
php Null-Object/Examples/DiscountApplication/bad.php
php Null-Object/Examples/DiscountApplication/good.php
```
