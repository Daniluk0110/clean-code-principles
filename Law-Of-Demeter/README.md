# Law Of Demeter 🧠

Принцип наименьшего знания: "Не разговаривай с незнакомцами". Объект должен вызывать методы только своих прямых зависимостей, а не объектов, которые находятся глубоко внутри графа.

## Суть правила 📌
- Общайся только с теми объектами, которые тебе непосредственно переданы.
- Не лезь в чужие внутренности и цепочки зависимостей.
- Скрывай детали реализации за методами делегирования.

## Почему это важно ⚙️
- Снижается связность между слоями.
- Изменения в одной части модели меньше ломают другую.
- Код проще рефакторить и тестировать.

## Запахи кода 👃
- Цепочки вызовов (Train Wrecks): `$a->b()->c()->d()`.
- Хрупкие зависимости между слоями модели.

## Было (Плохо) ❌

`$order->getCustomer()->getProfile()->getBillingAddress()->getZipCode()` выглядит красиво, но это хрупко: достаточно поменять структуру профиля, и цепочка сломается. Код знает слишком много о внутренних деталях других объектов.

```php
<?php

declare(strict_types=1);

final class Address
{
    public function __construct(private string $zipCode)
    {
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }
}

final class Profile
{
    public function __construct(private Address $billingAddress)
    {
    }

    public function getBillingAddress(): Address
    {
        return $this->billingAddress;
    }
}

final class Customer
{
    public function __construct(private Profile $profile)
    {
    }

    public function getProfile(): Profile
    {
        return $this->profile;
    }
}

final class Order
{
    public function __construct(private Customer $customer)
    {
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }
}

$order = new Order(
    new Customer(
        new Profile(
            new Address('10115')
        )
    )
);

$zip = $order->getCustomer()
    ->getProfile()
    ->getBillingAddress()
    ->getZipCode();

echo "ZIP: {$zip}\n";
```

## Стало (Хорошо) ✅

Делегируем доступ к нужному значению. Каждый объект скрывает свои внутренности.

```php
<?php

declare(strict_types=1);

final class Address
{
    public function __construct(private string $zipCode)
    {
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }
}

final class Profile
{
    public function __construct(private Address $billingAddress)
    {
    }

    public function getBillingZipCode(): string
    {
        return $this->billingAddress->getZipCode();
    }
}

final class Customer
{
    public function __construct(private Profile $profile)
    {
    }

    public function getBillingZipCode(): string
    {
        return $this->profile->getBillingZipCode();
    }
}

final class Order
{
    public function __construct(private Customer $customer)
    {
    }

    public function getBillingZipCode(): string
    {
        return $this->customer->getBillingZipCode();
    }
}

$order = new Order(
    new Customer(
        new Profile(
            new Address('10115')
        )
    )
);

$zip = $order->getBillingZipCode();

echo "ZIP: {$zip}\n";
```

## Примеры запуска ▶️

```bash
php Law-Of-Demeter/Examples/bad.php
php Law-Of-Demeter/Examples/good.php
```
