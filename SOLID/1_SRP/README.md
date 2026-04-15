# SRP — Single Responsibility Principle 🧩

**Расшифровка (EN):** Single Responsibility Principle.  
**Расшифровка (RU):** Принцип единственной ответственности.

**Суть:** у класса должна быть одна причина для изменения — одна четкая зона ответственности. ✅

## Почему важно: маленькие, сфокусированные классы проще тестировать, расширять и менять без побочных эффектов. 💡

### 💸 Бизнес-риски
- **Частые баги (Regression):** Если один класс отвечает и за расчет цен, и за отправку email, изменение шаблона письма может случайно сломать расчет налогов. Бизнес теряет деньги.
- **Merge Conflicts:** Когда вся команда работает над одним `OrderProcessor`, постоянно возникают конфликты слияния веток. Разработчики тратят часы на разрешение конфликтов, а не на фичи.

## Теория простыми словами 📌
- Ответственность — это изменяемость по одной причине, а не один метод.
- Если требования меняются в двух разных сценариях, это уже две ответственности.
- Чем четче границы, тем легче поддержка и переиспользование.

## Как распознать границы 🧭
- Изменения в логировании не должны ломать бизнес-логику.
- Изменения в уведомлениях не должны трогать расчет итогов.
- Отдельные причины — отдельные классы.

## Запахи кода 👃
- Класс делает «всё подряд»: бизнес‑логика + логирование + отправка уведомлений.
- Слишком много причин для изменения в одном файле.
- Много разных зависимостей и несвязанных методов.
- Тесты требуют сложных стабов/моков из‑за перегруженности класса.

## Было (Плохо) ❌
```php
<?php

declare(strict_types=1);

final class OrderProcessor
{
    public function process(array $items, string $email): void
    {
        $total = 0.0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $this->log("Order total: {$total}");
        $this->sendEmail($email, $total);
    }

    private function log(string $message): void
    {
        file_put_contents('orders.log', $message . PHP_EOL, FILE_APPEND);
    }

    private function sendEmail(string $email, float $total): void
    {
        file_put_contents('mail.log', "Email to {$email}: total {$total}" . PHP_EOL, FILE_APPEND);
    }
}
```

## Стало (Хорошо) ✅
```php
<?php

declare(strict_types=1);

final class OrderTotalCalculator
{
    public function calculate(array $items): float
    {
        $total = 0.0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['qty'];
        }

        return $total;
    }
}

final class OrderLogger
{
    public function logTotal(float $total): void
    {
        file_put_contents('orders.log', "Order total: {$total}" . PHP_EOL, FILE_APPEND);
    }
}

final class ReceiptEmailSender
{
    public function send(string $email, float $total): void
    {
        file_put_contents('mail.log', "Email to {$email}: total {$total}" . PHP_EOL, FILE_APPEND);
    }
}

final class OrderProcessor
{
    public function __construct(
        private OrderTotalCalculator $calculator,
        private OrderLogger $logger,
        private ReceiptEmailSender $sender,
    ) {}

    public function process(array $items, string $email): void
    {
        $total = $this->calculator->calculate($items);
        $this->logger->logTotal($total);
        $this->sender->send($email, $total);
    }
}
```

## Пример мини‑системы (Examples/) 🧪
В папке `Examples/OrderProcessing/` лежат две версии кода:
- `Dirty/OrderProcessor.php` (Монолит с несколькими ответственностями)
- `Clean/OrderTotalCalculator.php`, `OrderLogger.php`, `ReceiptEmailSender.php`, `index.php` (Код, разбитый по SRP)

### 🧪 Как это тестировать?
Тестировать грязный класс `OrderProcessor` сложно: при тестировании логики расчета вам придется создавать моки для логгера и почтового клиента, хотя они вообще не должны участвовать в расчете.

А вот чистый код тестируется легко:
```php
public function testTotalIsCalculatedCorrectly(): void
{
    $calculator = new OrderTotalCalculator();
    $total = $calculator->calculate([
        ['price' => 10, 'qty' => 2],
        ['price' => 5, 'qty' => 1]
    ]);

    $this->assertEquals(25.0, $total);
}
```

Запуск:
```bash
php SOLID/1_SRP/Examples/OrderProcessing/Dirty/OrderProcessor.php
php SOLID/1_SRP/Examples/OrderProcessing/Clean/index.php
```
