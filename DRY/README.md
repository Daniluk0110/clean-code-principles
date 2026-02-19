# DRY

DRY (Don't Repeat Yourself) — принцип, который требует избегать дублирования бизнес-логики и знаний о домене в разных местах кода. Идея в том, чтобы каждый бизнес-правилo или алгоритм имели единственный источник истины.

Важно различать:
- Случайное совпадение кода: два фрагмента выглядят одинаково, но представляют разные бизнес-смыслы. Объединение такого кода в общий модуль часто приводит к неявной связности и ошибкам.
- Реальное дублирование бизнес-логики: один и тот же алгоритм или правило повторяются в разных местах. Здесь нужен общий модуль, иначе изменения начнут расходиться.

## Запахи кода
- Copy-Paste Driven Development: новые фичи делаются копированием существующих фрагментов с минимальными правками.
- Расхождение логики при изменениях: одинаковые правила со временем начинают вести себя по-разному, потому что правки внесли только в одном месте.

## Было (Плохо)

Два сервиса используют один и тот же сложный алгоритм расчета НДС и скидок, но реализация скопирована.

```php
<?php

declare(strict_types=1);

final class OrderService
{
    public function calculateTotal(float $subtotal, float $discountPercent, string $countryCode): float
    {
        $discounted = $subtotal - ($subtotal * $discountPercent / 100);
        $vatRate = $this->vatRateByCountry($countryCode);
        $vat = $discounted * $vatRate;

        if ($discounted > 500) {
            $vat -= 5;
        }

        return round($discounted + $vat, 2);
    }

    private function vatRateByCountry(string $countryCode): float
    {
        return match ($countryCode) {
            'DE' => 0.19,
            'PL' => 0.23,
            'FR' => 0.20,
            default => 0.21,
        };
    }
}

final class SubscriptionService
{
    public function calculateTotal(float $subtotal, float $discountPercent, string $countryCode): float
    {
        $discounted = $subtotal - ($subtotal * $discountPercent / 100);
        $vatRate = $this->vatRateByCountry($countryCode);
        $vat = $discounted * $vatRate;

        if ($discounted > 500) {
            $vat -= 5;
        }

        return round($discounted + $vat, 2);
    }

    private function vatRateByCountry(string $countryCode): float
    {
        return match ($countryCode) {
            'DE' => 0.19,
            'PL' => 0.23,
            'FR' => 0.20,
            default => 0.21,
        };
    }
}
```

## Стало (Хорошо)

Алгоритм расчета НДС и скидок вынесен в отдельный сервис. У сервисов остается только координация процесса.

```php
<?php

declare(strict_types=1);

final class TaxCalculator
{
    public function calculateTotal(float $subtotal, float $discountPercent, string $countryCode): float
    {
        $discounted = $subtotal - ($subtotal * $discountPercent / 100);
        $vatRate = $this->vatRateByCountry($countryCode);
        $vat = $discounted * $vatRate;

        if ($discounted > 500) {
            $vat -= 5;
        }

        return round($discounted + $vat, 2);
    }

    private function vatRateByCountry(string $countryCode): float
    {
        return match ($countryCode) {
            'DE' => 0.19,
            'PL' => 0.23,
            'FR' => 0.20,
            default => 0.21,
        };
    }
}

final class OrderService
{
    public function __construct(private TaxCalculator $taxCalculator)
    {
    }

    public function calculateTotal(float $subtotal, float $discountPercent, string $countryCode): float
    {
        return $this->taxCalculator->calculateTotal($subtotal, $discountPercent, $countryCode);
    }
}

final class SubscriptionService
{
    public function __construct(private TaxCalculator $taxCalculator)
    {
    }

    public function calculateTotal(float $subtotal, float $discountPercent, string $countryCode): float
    {
        return $this->taxCalculator->calculateTotal($subtotal, $discountPercent, $countryCode);
    }
}
```

## Примеры запуска

```bash
php DRY/Examples/bad.php
php DRY/Examples/good.php
```
