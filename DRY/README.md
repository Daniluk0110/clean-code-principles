# DRY 🔁

Раздел о принципе DRY с реальными бизнес-примерами на PHP 8.4+ и строгой типизацией.

## Что такое DRY 📌
DRY (Don't Repeat Yourself) требует избегать дублирования бизнес-логики и доменных знаний. Каждый бизнес-алгоритм должен иметь единственный источник истины.

Важно различать:
- Случайное совпадение кода: фрагменты похожи технически, но отражают разный бизнес-смысл. Объединять такой код не нужно.
- Реальное дублирование логики: один и тот же алгоритм повторяется в разных местах. Здесь нужен общий модуль, иначе изменения расходятся.

## Запахи кода 👃
- Copy-Paste Driven Development: новая функциональность появляется путем копирования существующей логики.
- Расхождение логики при изменениях: одно правило меняется в одном месте и остается старым в другом.

## Формат примеров 🧪
- Было (Плохо) -> Стало (Хорошо)
- Реальные задачи: e-commerce, подписки, налоги, скидки

## Было (Плохо) ❌

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

## Стало (Хорошо) ✅

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

## Примеры запуска ▶️

```bash
php DRY/Examples/bad.php
php DRY/Examples/good.php
```
