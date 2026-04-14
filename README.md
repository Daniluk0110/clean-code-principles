# Чистый код на PHP 8.4+ 🚀

[![PHP 8.4+](https://img.shields.io/badge/PHP-8.4%2B-blue?logo=php&logoColor=white)](https://www.php.net/releases/8.4/)
[![License](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)](https://github.com/Daniluk0110/clean-code-principles/pulls)
[![CI](https://github.com/Daniluk0110/clean-code-principles/actions/workflows/ci.yml/badge.svg)](https://github.com/Daniluk0110/clean-code-principles/actions/workflows/ci.yml)

Этот репозиторий — практический гид по принципам чистого кода для реальных бизнес‑задач на PHP. Здесь нет абстрактных животных и фигур — только e‑commerce, платежи, нотификации, интеграции и отчеты. Цель — показать, как писать поддерживаемый, надежный и расширяемый код, который не ломается при росте продукта. ✨

**🗺️ Дорожная карта изучения**
- **Junior → Middle (рекомендуемый порядок):** KISS → Early-Exit → DRY → YAGNI → Naming → Fail-Fast → SOLID (S → O → L → I → D) → Law-Of-Demeter → Value-Objects → Code-Smells → Refactoring-Kata
- **Middle → Senior (для тех, кто уже знает SOLID):** Value-Objects → Immutability → Fail-Fast → CQS → Composition-Over-Inheritance → Code-Smells → Refactoring-Kata

## Оглавление
- 🧱 **SOLID**
  - S — Single Responsibility
  - O — Open-Closed
  - L — Liskov Substitution
  - I — Interface Segregation
  - D — Dependency Inversion
  - Все принципы вместе
- 🔁 **Базовые принципы**
  - DRY
  - KISS
  - YAGNI
- 🛠️ **Практики чистого кода**
  - Early Exit / Guard Clauses
  - Law of Demeter
  - Fail-Fast
  - Immutability
  - Value Objects
  - Command Query Separation
  - Composition Over Inheritance
- 🗺️ **Справочники**
  - [Naming Cheat Sheet](#-naming-cheat-sheet)
  - [Code Smells каталог](Code-Smells/README.md)
  - [Value Objects каталог](Value-Objects/README.md)
- 🏆 **Финальный босс**
  - Refactoring Kata

**Базовые принципы**

## Refactoring Kata 🏆
Финальный босс: искушение применить все изученные принципы. Папка [`Refactoring-Kata/`](Refactoring-Kata) содержит dirty-код, задачку и решение, которое можно сравнить после собственной попытки.

## SOLID 🧱
**Расшифровка (EN):** Single Responsibility, Open/Closed, Liskov Substitution, Interface Segregation, Dependency Inversion.
**Просто (RU):** один класс — одна ответственность; расширяем без изменения; подтипы не ломают ожидания; интерфейсы узкие; зависимости через абстракции.

**Суть:** проектируй модули так, чтобы они были ответственными за одно, расширяемыми и слабо связанными.

**Почему важно:** снижает риск поломок при изменениях и упрощает тестирование.

**Плохо ❌**
```php
<?php

declare(strict_types=1);

final class OrderService
{
    public function payAndSendReceipt(int $orderId): void
    {
        // Оплата
        $this->chargeCard($orderId);

        // Отправка письма
        $this->sendEmail($orderId);
    }

    private function chargeCard(int $orderId): void
    {
        // Работа с платежным шлюзом
    }

    private function sendEmail(int $orderId): void
    {
        // SMTP логика
    }
}
```

**Хорошо ✅**
```php
<?php

declare(strict_types=1);

interface PaymentGateway
{
    public function charge(int $orderId): void;
}

interface ReceiptSender
{
    public function send(int $orderId): void;
}

final class OrderService
{
    public function __construct(
        private PaymentGateway $gateway,
        private ReceiptSender $sender,
    ) {}

    public function payAndSendReceipt(int $orderId): void
    {
        $this->gateway->charge($orderId);
        $this->sender->send($orderId);
    }
}
```

## DRY 🔁
**Расшифровка (EN):** Don't Repeat Yourself.
**Просто (RU):** одна бизнес‑идея — одно место в коде.

**Суть:** не повторяй одну и ту же бизнес‑логику в нескольких местах.

**Почему важно:** правки в одном месте не должны требовать десяток синхронных изменений.

**Плохо ❌**
```php
<?php

declare(strict_types=1);

final class CartService
{
    public function totalWithDiscount(float $total): float
    {
        return $total >= 1000 ? $total * 0.9 : $total;
    }
}

final class OrderReport
{
    public function buildTotal(float $total): float
    {
        return $total >= 1000 ? $total * 0.9 : $total;
    }
}
```

**Хорошо ✅**
```php
<?php

declare(strict_types=1);

final class DiscountCalculator
{
    public function apply(float $total): float
    {
        return $total >= 1000 ? $total * 0.9 : $total;
    }
}

final class CartService
{
    public function __construct(private DiscountCalculator $discounts) {}

    public function totalWithDiscount(float $total): float
    {
        return $this->discounts->apply($total);
    }
}

final class OrderReport
{
    public function __construct(private DiscountCalculator $discounts) {}

    public function buildTotal(float $total): float
    {
        return $this->discounts->apply($total);
    }
}
```

## KISS 🧩
**Расшифровка (EN):** Keep It Simple, Stupid.
**Просто (RU):** не усложняй без причины.

**Суть:** выбирай самое простое решение, которое реально решает задачу.

**Почему важно:** простой код легче читать, поддерживать и тестировать.

**Плохо ❌**
```php
<?php

declare(strict_types=1);

final class ApiUrlBuilder
{
    public function build(string $base, array $params): string
    {
        return $base . '?' . http_build_query($params);
    }

    public function buildViaPipeline(string $base, array $params): string
    {
        return (new 
            class($base, $params) {
                public function __construct(private string $base, private array $params) {}
                public function make(): string { return $this->base . '?' . http_build_query($this->params); }
            }
        )->make();
    }
}
```

**Хорошо ✅**
```php
<?php

declare(strict_types=1);

final class ApiUrlBuilder
{
    public function build(string $base, array $params): string
    {
        return $base . '?' . http_build_query($params);
    }
}
```

## YAGNI ⛔
**Расшифровка (EN):** You Aren't Gonna Need It.
**Просто (RU):** не пиши то, что не нужно прямо сейчас.

**Суть:** не реализуй функциональность, которая «может понадобиться потом».

**Почему важно:** лишний код усложняет систему и увеличивает стоимость изменений.

**Плохо ❌**
```php
<?php

declare(strict_types=1);

final class InvoiceGenerator
{
    public function generatePdf(int $invoiceId): string
    {
        return $this->renderPdf($invoiceId);
    }

    public function generateXml(int $invoiceId): string
    {
        // "на будущее"
        return $this->renderXml($invoiceId);
    }

    private function renderPdf(int $invoiceId): string
    {
        return 'PDF';
    }

    private function renderXml(int $invoiceId): string
    {
        return 'XML';
    }
}
```

**Хорошо ✅**
```php
<?php

declare(strict_types=1);

final class InvoiceGenerator
{
    public function generatePdf(int $invoiceId): string
    {
        return $this->renderPdf($invoiceId);
    }

    private function renderPdf(int $invoiceId): string
    {
        return 'PDF';
    }
}
```

## 📝 Naming Cheat Sheet

| ❌ Плохое имя | ✅ Хорошее имя | 💡 Правило | 📍 Контекст |
| --- | --- | --- | --- |
| handle() | processRefundRequest() | Метод должен говорить ЧТО он делает | Service |
| process() | importProductsFromCsv() | Избегай глаголов-пустышек | Importer |
| do() | calculateOrderDiscount() | Нет глаголам без смысла | Calculator |
| manage() | activateUserSubscription() | Управление чем? Будь конкретен | Manager |
| run() | sendPasswordResetEmail() | Что запускаем? | Notification |
| execute() | chargeCustomerCard() | Что выполняем? | Payment |
| $data | $rawProductsArray | Что за данные? | Parser |
| $result | $calculatedDiscount | Результат чего? | Calculator |
| $temp | $pendingOrderIds | Временное что? | Service |
| $item | $cartLineItem | Элемент чего? | Cart |
| $value | $unitPriceInCents | Значение чего? | Money |
| $info | $customerBillingAddress | Какая инфо? | Order |
| $active | $isActive | Булевы всегда is/has/can/should | User |
| $check | $hasUnpaidInvoices | Проверка чего? | Billing |
| $allowed | $canProcessRefund | Разрешение на что? | Order |
| $flag | $shouldSendWelcomeEmail | Флаг чего? | Registration |
| DataProcessor | CsvProductImporter | Что обрабатывает и откуда? | Import |
| Manager | SubscriptionRenewalService | Менеджер чего конкретно? | Billing |
| Helper | VatCalculator | Helper это мусорное слово | Tax |
| Utils | DateRangeFormatter | Utils это мусорное слово | Report |

### 🚨 Стоп-слова

Методы: `handle`, `process`, `do`, `run`, `execute`, `manage`, `perform`. Эти слова скрывают смысл и не объясняют, какое действие выполняется.

Классы: `Manager`, `Helper`, `Utils`, `Handler`, `Processor`, `Data`, `Info`. Эти названия размывают роль и превращают классы в «контейнеры всего».

Переменные: `$data`, `$result`, `$temp`, `$item`, `$value`, `$obj`, `$flag`. Эти имена не дают контекста и усложняют чтение кода.
